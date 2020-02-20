<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   12/01/2020
 * @time  :   14:04
 */

namespace App\Accounting\Service;


use App\Accounting\Entity\ScholarshipPaymentPlan;
use App\Manager\Service\ManagerService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ScholarshipPaymentPlanService
 *
 * @package App\Accounting\Service
 *
 */
class ScholarshipPaymentPlanService extends ManagerService {
    /**
     * @return array
     */
    public function getByPayment() {
        $id      = $this->getRequest()->get('id');
        $records = $this->getEm()->getRepository(ScholarshipPaymentPlan::class)->findByScholarshipPayment($id);
        
        return $this->getScholarshipPendingPaymentPlan($records);
    }
    
    /**
     * @return array
     */
    public function pendingScholarshipPaymentPlan() {
        $records = $this->getEm()->getRepository(ScholarshipPaymentPlan::class)->findBy(['status' => ScholarshipPaymentPlan::PAYMENT_INIT]);
        
        return $this->getScholarshipPendingPaymentPlan($records);
    }
    
    /**
     * @return array
     */
    public function pendingCheque() {
        $records = $this->getEm()->getRepository(ScholarshipPaymentPlan::class)->findBy(['status' => ScholarshipPaymentPlan::PAYMENT_CHQ_W]);
        
        $headers = [
            $this->getTranslator()->trans('Libellé'),
            $this->getTranslator()->trans('Montant'),
            $this->getTranslator()->trans('Date d\'enregistrement'),
            $this->getTranslator()->trans('Date de paiement'),
            $this->getTranslator()->trans('Statut'),
            '',
            '',
        ];
        $table   = $this->getTable('pendingCheque');
        $table->addHeaders($headers);
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('libelle', $record->getLabel()));
                $row->addCells($this->getCell('montant', $record->getAmount(), '', 'money'));
                $row->addCells($this->getCell('dateEnregistrement', $record->getRegistrationDate(), '', 'date'));
                $row->addCells($this->getCell('dateEncaissement', $record->getDateOfCollection(), '', 'date'));
                $row->addCells($this->getCell('label', $this->getStatusLabel($record->getStatus())));
                $cell       = $this->getCell('action');
                $cellAction = $this->getCellAction('pay', 'link');
                $params     = ['scholarshippaymentplan_id' => $record->getId(),
                               'scholarshippayment_id'     => $record->getScholarshipPayment()->getId(),
                               'mode'                      => 'CHQ_VALID',
                               'redirect'                  => 'scholarshippaymentplan_pending_transactions',
                ];
                $cellAction->setCellattribute(
                    $this->getCellAttribute(
                        'far fa-credit-card',
                        $this->getTranslator()->trans('Valider l\'encaissement du chèque'),
                        'scholarshippaymentplan_update_status',
                        'green darken-2 white-text',
                        '',
                        $params
                    )
                );
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('action');
                $cellAction = $this->getCellAction('delete', 'link');
                // Dell attribute
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', 'Supprimer', 'scholarshippaymentplan_del', 'bg-danger'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $table->addRows($row);
            }
        }
        
        return [
            'table'      => $table,
            'pagination' => null,
        ];
    }
    
    /**
     * @return array
     */
    public function noValidBankTransfert() {
        $records = $this->getEm()->getRepository(ScholarshipPaymentPlan::class)->findBy(['status' => ScholarshipPaymentPlan::PAYMENT_BANK_TFT_W]);
        
        $headers = [
            'Libellé',
            'Montant',
            'Date d\'enregistrement',
            'Date de paiement',
            'Statut',
            '',
            '',
        
        ];
        $table   = $this->getTable('noValidBankTransfert');
        $table->addHeaders($headers);
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('label', $record->getLabel()));
                $row->addCells($this->getCell('montant', $record->getAmount(), '', 'money'));
                $row->addCells($this->getCell('dateEnregistrement', $record->getRegistrationDate(), '', 'date'));
                $row->addCells($this->getCell('dateEncaissement', $record->getDateOfCollection(), '', 'date'));
                $row->addCells($this->getCell('status', $this->getStatusLabel($record->getStatus())));
                $cell       = $this->getCell('action');
                $cellAction = $this->getCellAction('pay', 'link');
                
                $params = ['paymentplan_id' => $record->getId(),
                           'payment_id'     => $record->getPayment()->getId(),
                           'mode'           => 'BANK_VALID',
                           'redirect'       => 'scholarshippaymentplan_pending_transactions',
                ];
                $cellAction->setCellattribute(
                    $this->getCellAttribute(
                        'far fa-credit-card',
                        $this->getTranslator()->trans('Valider la reception du paiement par virement bancaire'),
                        'paymentplan_update_status',
                        'green darken-2 white-text',
                        '',
                        $params
                    )
                );
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('action');
                $cellAction = $this->getCellAction('delete', 'link');
                // Dell attribute
                $cellAction->setCellattribute(
                    $this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'scholarshippaymentplan_del', 'bg-danger white-text')
                );
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $table->addRows($row);
            }
        }
        
        return [
            'table'      => $table,
            'pagination' => null,
        ];
    }
    
    /**
     * @param $records
     *
     * @return array
     */
    public function getScholarshipPendingPaymentPlan($records) {
        $headers = [
            $this->getTranslator()->trans('Référence'),
            $this->getTranslator()->trans('Libellé'),
            $this->getTranslator()->trans('Montant'),
            $this->getTranslator()->trans('Date d\'enregistrement'),
            $this->getTranslator()->trans('Date de paiement'),
            $this->getTranslator()->trans('Statut'),
            '',
            '',
            '',
        
        ];
        $table   = $this->getTable('payementplan');
        $table->addHeaders($headers);
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('reference', $record->getReference()));
                $row->addCells($this->getCell('libelle', $record->getLabel()));
                $row->addCells($this->getCell('montant', $record->getAmount(), '', 'money'));
                $row->addCells($this->getCell('dateEnregistrement', $record->getRegistrationDate(), '', 'date'));
                $row->addCells($this->getCell('dateEncaissement', $record->getDateOfCollection(), '', 'date'));
                $row->addCells($this->getCell('label', $this->getStatusLabel($record->getStatus())));
                
                if ($record->getStatus() == ScholarshipPaymentPlan::PAYMENT_INIT) {
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('pay', 'link');
                    
                    $params = [
                        'scholarshippaymentplan_id' => $record->getId(),
                        'scholarshippayment_id'     => $record->getScholarshipPayment()->getId(),
                        'mode'                      => 'BANK',
                    ];
                    $cellAction->setCellattribute(
                        $this->getCellAttribute(
                            'far fa-credit-card',
                            $this->getTranslator()->trans('Effectuer le paiement par virement bancaire'),
                            'scholarshippaymentplan_update_status',
                            'grey darken-1 white-text',
                            '',
                            $params
                        )
                    );
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                    
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('pay', 'link');
                    $params     = ['scholarshippaymentplan_id' => $record->getId()];
                    $cellAction->setCellattribute(
                        $this->getCellAttribute(
                            'fas fa-money-check',
                            $this->getTranslator()->trans('Effectuer le paiement par chèque'),
                            'cheque_add',
                            'blue darken-4 white-text',
                            '',
                            $params
                        )
                    );
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                }
                
                if ($record->getStatus() == ScholarshipPaymentPlan::PAYMENT_BANK_TFT_W) {
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('pay', 'link');
                    
                    $params = [
                        'scholarshippaymentplan_id' => $record->getId(),
                        'scholarshippayment_id'     => $record->getScholarshipPayment()->getId(),
                        'mode'                      => 'BANK_VALID',
                    ];
                    $cellAction->setCellattribute(
                        $this->getCellAttribute(
                            'far fa-credit-card',
                            $this->getTranslator()->trans('Valider la reception du paiement par virement bancaire'),
                            'scholarshippaymentplan_update_status',
                            'green darken-2 white-text',
                            '',
                            $params
                        )
                    );
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                    
                    $cell = $this->getCell('action');
                    $row->addCells($cell);
                }
                
                if ($record->getStatus() == ScholarshipPaymentPlan::PAYMENT_CHQ_W) {
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('pay', 'link');
                    
                    $params = [
                        'scholarshippaymentplan_id' => $record->getId(),
                        'scholarshippayment_id'     => $record->getScholarshipPayment()->getId(),
                        'mode'                      => 'CHQ_VALID',
                    ];
                    $cellAction->setCellattribute(
                        $this->getCellAttribute(
                            'fas fa-money-check',
                            $this->getTranslator()->trans('Valider l\'encaissement du chèque'),
                            'scholarshippaymentplan_update_status',
                            'green darken-2 white-text',
                            '',
                            $params
                        )
                    );
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                }
                
                if ($record->getStatus() == ScholarshipPaymentPlan::PAYMENT_CHQ_V || $record->getStatus() ==
                    ScholarshipPaymentPlan::PAYMENT_BANK_TFT_V) {
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('pdf', 'link');
                    // Dell attribute
                    $params = ['id' => $record->getId(), 'scholarshippayment_id' => $record->getScholarshipPayment()->getId()];
                    $cellAction->setCellattribute(
                        $this->getCellAttribute(
                            'far fa-file-pdf',
                            $this->getTranslator()->trans('Télécharger le reçu'),
                            'scholarshippaymentplan_payment_receipt',
                            'yellow white-text',
                            '',
                            $params
                        )
                    );
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                }
                
                $cell       = $this->getCell('action');
                $cellAction = $this->getCellAction('delete', 'link');
                // Dell attribute
                $params = ['id' => $record->getId(), 'scholarshippayment_id' => $record->getScholarshipPayment()->getId()];
                $cellAction->setCellattribute(
                    $this->getCellAttribute(
                        'fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'scholarshippaymentplan_del', 'bg-danger white-text', '', $params
                    )
                );
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                
                $table->addRows($row);
            }
        }
        
        return [
            'table'      => $table,
            'pagination' => null,
        ];
    }
    
    /**
     * @return JsonResponse
     */
    public function updateStatus() {
        $response = new JsonResponse();
        try {
            $mode          = $this->getRequest()->get('mode');
            $paymentPlanId = $this->getRequest()->get('scholarshippaymentplan_id');
            $paymentPlan   = $this->getEm()->getRepository(ScholarshipPaymentPlan::class)->find($paymentPlanId);
            if (!$paymentPlan) {
                throw new \Exception('ScholarshipPaymentPlan Id not found :'.$paymentPlanId);
            }
            
            if ($mode == 'BANK') {
                $paymentPlan->setStatus(ScholarshipPaymentPlan::PAYMENT_BANK_TFT_W);
                $this->getEm()->flush();
            }
            
            if ($mode == 'BANK_VALID') {
                $payment = $paymentPlan->getScholarshipPayment();
                $balance = $payment->getBalance() - $paymentPlan->getAmount();
                $payment->setBalance($balance);
                $this->getEm()->flush();
                $paymentPlan->setStatus(ScholarshipPaymentPlan::PAYMENT_BANK_TFT_V);
                $this->getEm()->flush();
            }
            
            if ($mode == 'CHQ_VALID') {
                $payment = $paymentPlan->getScholarshipPayment();
                $balance = $payment->getBalance() - $paymentPlan->getAmount();
                $payment->setBalance($balance);
                $this->getEm()->flush();
                $paymentPlan->setStatus(ScholarshipPaymentPlan::PAYMENT_CHQ_V);
                $this->getEm()->flush();
            }
            
            $this->getRequest()->getSession()->getFlashBag()->add(
                'notice',
                'Opération effectuée !'
            );
            $response->setData(
                [
                    'status'  => 'OK',
                    'message' => 'Opération effectuée !',
                ]
            );
        } catch (\Exception $e) {
            $this->getRequest()->getSession()->getFlashBag()->add(
                'danger',
                'Une erreur est intervenue: '.$e->getMessage()
            );
            $response->setData(
                [
                    'statut'  => 'NOK',
                    'message' => 'Une erreur est intervenue! : '.$e->getMessage(),
                ]
            );
        }
        
        return $response;
    }
    
    /**
     * @param $statusID
     *
     * @return string
     */
    public function getStatusLabel($statusID) {
        switch ($statusID) {
            case ScholarshipPaymentPlan::PAYMENT_INIT:
                return $this->getTranslator()->trans('En attente de paiement');
                break;
            case ScholarshipPaymentPlan::PAYMENT_CASH:
                return $this->getTranslator()->trans('Paiement en espèce');
                break;
            case ScholarshipPaymentPlan::PAYMENT_CHQ_W:
                return $this->getTranslator()->trans('Chèque en attente');
            case ScholarshipPaymentPlan::PAYMENT_CHQ_V:
                return $this->getTranslator()->trans('Chèque encaissé');
                break;
            case ScholarshipPaymentPlan::PAYMENT_CHQ_C:
                return $this->getTranslator()->trans('Chèque rejetté');
                break;
            case ScholarshipPaymentPlan::PAYMENT_BANK_TFT_W:
                return $this->getTranslator()->trans('Virement bancaire en attente');
                break;
            case ScholarshipPaymentPlan::PAYMENT_BANK_TFT_V:
                return $this->getTranslator()->trans('Virement bancaire effectué');
                break;
            case ScholarshipPaymentPlan::PAYMENT_BANK_TFT_C:
                return $this->getTranslator()->trans('Virement bancaire annulé');
                break;
            case ScholarshipPaymentPlan::PAYMENT_CNL:
                return $this->getTranslator()->trans('Paiement annulé');
                break;
        }
    }
    
    /**
     * @return mixed
     */
    public function downloadPaymentReceipt() {
        return $this->getEm()->getRepository(ScholarshipPaymentPlan::class)->find($this->getRequest()->get('id'));
    }
    
    /**
     * @return mixed
     */
    public function chequeValidedScholarshipPaymentPlan() {
        $records = $this->getEm()->getRepository(ScholarshipPaymentPlan::class)->findBy(['status' => ScholarshipPaymentPlan::PAYMENT_CHQ_V]);
        
        return $this->getValidedPaymentPlan($records);
    }
    
    /**
     * @return array
     */
    public function transfertValidedScholarshipPaymentPlan() {
        $records = $this->getEm()->getRepository(ScholarshipPaymentPlan::class)->findBy(['status' => ScholarshipPaymentPlan::PAYMENT_BANK_TFT_V]);
        
        return $this->getValidedPaymentPlan($records);
    }
    
    /**
     * @param $records
     *
     * @return array
     */
    public function getValidedPaymentPlan($records) {
        $headers = [
            $this->getTranslator()->trans('Référence'),
            $this->getTranslator()->trans('Libellé'),
            $this->getTranslator()->trans('Montant'),
            $this->getTranslator()->trans('Date d\'enregistrement'),
            $this->getTranslator()->trans('Date de paiement'),
            $this->getTranslator()->trans('Statut'),
            '',
        
        ];
        $table   = $this->getTable('validedpayementplan');
        $table->addHeaders($headers);
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('reference', $record->getReference()));
                $row->addCells($this->getCell('libelle', $record->getLabel()));
                $row->addCells($this->getCell('montant', $record->getAmount(), '', 'money'));
                $row->addCells($this->getCell('dateEnregistrement', $record->getRegistrationDate(), '', 'date'));
                $row->addCells($this->getCell('dateEncaissement', $record->getDateOfCollection(), '', 'date'));
                $row->addCells($this->getCell('label', $this->getStatusLabel($record->getStatus())));
                
                $cell       = $this->getCell('action');
                $cellAction = $this->getCellAction('delete', 'link');
                // Dell attribute
                $params = ['id' => $record->getId(), 'scholarshippayment_id' => $record->getScholarshipPayment()->getId()];
                $cellAction->setCellattribute(
                    $this->getCellAttribute(
                        'fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'scholarshippaymentplan_del', 'bg-danger white-text', '',
                        $params
                    )
                );
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                
                $table->addRows($row);
            }
        }
        
        return [
            'table'      => $table,
            'pagination' => null,
        ];
    }
}