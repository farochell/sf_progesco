<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   17:24
 */

namespace App\Accounting\Service;


use App\Accounting\Entity\PaymentPlan;
use App\Manager\Service\ManagerService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PaymentPlanService
 *
 * @package App\Accounting\Service
 *
 */
class PaymentPlanService extends ManagerService
{
    /**
     * @return array
     */
    public function getByPayment()
    {
        $id      = $this->getRequest()->get('id');
        $records = $this->getEm()->getRepository(PaymentPlan::class)->findByPayment($id);
        return $this->getPendingPaymentPlan($records);
    }
    
    /**
     * @return array
     */
    public function pendingPaymentPlan()
    {
        $records = $this->getEm()->getRepository(PaymentPlan::class)->findBy(['status' => PaymentPlan::PAYMENT_INIT]);
        return $this->getPendingPaymentPlan($records);
    }
    
    /**
     * @return array
     */
    public function cashValidedPaymentPlan()
    {
        $records = $this->getEm()->getRepository(PaymentPlan::class)->findBy(['status' => PaymentPlan::PAYMENT_CASH]);
        return $this->getValidedPaymentPlan($records);
    }
    
    /**
     * @return array
     */
    public function chequeValidedPaymentPlan()
    {
        $records = $this->getEm()->getRepository(PaymentPlan::class)->findBy(['status' => PaymentPlan::PAYMENT_CHQ_V]);
        return $this->getValidedPaymentPlan($records);
    }
    
    /**
     * @return array
     */
    public function transfertValidedPaymentPlan()
    {
        $records = $this->getEm()->getRepository(PaymentPlan::class)->findBy(['status' => PaymentPlan::PAYMENT_BANK_TFT_V]);
        return $this->getValidedPaymentPlan($records);
    }
    /**
     * @param $records
     *
     * @return array
     */
    public function getPendingPaymentPlan($records) {
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
            
                if ($record->getStatus() == PaymentPlan::PAYMENT_INIT) {
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('pay', 'link');
                
                    $params = ['paymentplan_id' => $record->getId(), 'payment_id' => $record->getPayment()->getId(), 'mode' => 'CASH'];
                    $cellAction->setCellattribute(
                        $this->getCellAttribute(
                            'fas fa-money-bill-wave',
                            'Effectuer le paiement en espèce',
                            'paymentplan_update_status',
                            'green darken-1 white-text',
                            '',
                            $params
                        )
                    );
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('pay', 'link');
                
                    $params = ['paymentplan_id' => $record->getId(), 'payment_id' => $record->getPayment()->getId(), 'mode' => 'BANK'];
                    $cellAction->setCellattribute(
                        $this->getCellAttribute(
                            'far fa-credit-card',
                            $this->getTranslator()->trans('Effectuer le paiement par virement bancaire'),
                            'paymentplan_update_status',
                            'grey darken-1 white-text',
                            '',
                            $params
                        )
                    );
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('pay', 'link');
                    $params     = ['paymentplan_id' => $record->getId()];
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
            
                if ($record->getStatus() == PaymentPlan::PAYMENT_BANK_TFT_W) {
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('pay', 'link');
                
                    $params = ['paymentplan_id' => $record->getId(), 'payment_id' => $record->getPayment()->getId(), 'mode' => 'BANK_VALID'];
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
                    $row->addCells($cell);
                    $cell       = $this->getCell('action');
                    $row->addCells($cell);
                }
                
                if ($record->getStatus() == PaymentPlan::PAYMENT_CHQ_W) {
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('pay', 'link');
    
                    $params = ['paymentplan_id' => $record->getId(), 'payment_id' => $record->getPayment()->getId(), 'mode' => 'CHQ_VALID'];
                    $cellAction->setCellattribute(
                        $this->getCellAttribute(
                            'fas fa-money-check',
                            $this->getTranslator()->trans('Valider l\'encaissement du chèque'),
                            'paymentplan_update_status',
                            'green darken-2 white-text',
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
                $params = ['id' => $record->getId(), 'payment_id' => $record->getPayment()->getId()];
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'paymentplan_del',
                    'bg-danger white-text', '', $params));
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
    public function getValidedPaymentPlan($records) {
        $headers = [
            $this->getTranslator()->trans('Référence'),
            $this->getTranslator()->trans('Libellé'),
            $this->getTranslator()->trans('Montant'),
            $this->getTranslator()->trans('Date d\'enregistrement'),
            $this->getTranslator()->trans('Date de paiement'),
            $this->getTranslator()->trans('Statut'),
            ''
        
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
                $params = ['id' => $record->getId(), 'payment_id' => $record->getPayment()->getId()];
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'paymentplan_del',
                    'bg-danger white-text', '', $params));
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
    public function updateStatus()
    {
        $response = new JsonResponse();
        try {
            $mode          = $this->getRequest()->get('mode');
            $paymentPlanId = $this->getRequest()->get('paymentplan_id');
            $paymentPlan   = $this->getEm()->getRepository(PaymentPlan::class)->find($paymentPlanId);
            if (!$paymentPlan) {
                throw new \Exception('PaymentPlan Id not found :'.$paymentPlanId);
            }
            if ($mode == 'CASH') {
                $payment = $paymentPlan->getPayment();
                $balance = $payment->getBalance() - $paymentPlan->getAmount();
                $payment->setBalance($balance);
                $this->getEm()->flush();
                
                $paymentPlan->setStatus(PaymentPlan::PAYMENT_CASH);
                $this->getEm()->flush();
            }
            
            if ($mode == 'BANK') {
                $paymentPlan->setStatus(PaymentPlan::PAYMENT_BANK_TFT_W);
                $this->getEm()->flush();
            }
    
            if ($mode == 'BANK_VALID') {
                $payment = $paymentPlan->getPayment();
                $balance = $payment->getBalance() - $paymentPlan->getAmount();
                $payment->setBalance($balance);
                $this->getEm()->flush();
                $paymentPlan->setStatus(PaymentPlan::PAYMENT_BANK_TFT_V);
                $this->getEm()->flush();
            }
            
            if ($mode == 'CHQ_VALID') {
                $payment = $paymentPlan->getPayment();
                $balance = $payment->getBalance() - $paymentPlan->getAmount();
                $payment->setBalance($balance);
                $this->getEm()->flush();
                $paymentPlan->setStatus(PaymentPlan::PAYMENT_CHQ_V);
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
     * @return array
     */
    public function noValidBankTransfert() {
        $records = $this->getEm()->getRepository(PaymentPlan::class)->findBy(['status' => PaymentPlan::PAYMENT_BANK_TFT_W]);
    
        $headers = [
            $this->getTranslator()->trans('Libellé'),
            'Montant',
            $this->getTranslator()->trans('Date d\'enregistrement'),
            $this->getTranslator()->trans('Date de paiement'),
            $this->getTranslator()->trans('Statut'),
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
                           'payment_id' => $record->getPayment()->getId(),
                           'mode' => 'BANK_VALID',
                           'redirect' => 'paymentplan_pending_transactions'
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
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'paymentplan_del',
                    'bg-danger white-text'));
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
    public function pendingCheque() {
        $records = $this->getEm()->getRepository(PaymentPlan::class)->findBy(['status' => PaymentPlan::PAYMENT_CHQ_W]);
        
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
                $params = ['paymentplan_id' => $record->getId(),
                           'payment_id' => $record->getPayment()->getId(),
                           'mode' => 'CHQ_VALID',
                           'redirect' => 'paymentplan_pending_transactions'
                ];
                $cellAction->setCellattribute(
                    $this->getCellAttribute(
                        'far fa-credit-card',
                        $this->getTranslator()->trans('Valider l\'encaissement du chèque'),
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
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'paymentplan_del',
                    'bg-danger white-text'));
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
     * @param $statusID
     *
     * @return string
     */
    public function getStatusLabel($statusID)
    {
        switch ($statusID) {
            case PaymentPlan::PAYMENT_INIT:
                return $this->getTranslator()->trans('En attente de paiement');
                break;
            case PaymentPlan::PAYMENT_CASH:
                return $this->getTranslator()->trans('Paiement en espèce');
                break;
            case PaymentPlan::PAYMENT_CHQ_W:
                return $this->getTranslator()->trans('Chèque en attente');
            case PaymentPlan::PAYMENT_CHQ_V:
                return $this->getTranslator()->trans('Chèque encaissé');
                break;
            case PaymentPlan::PAYMENT_CHQ_C:
                return $this->getTranslator()->trans('Chèque rejetté');
                break;
            case PaymentPlan::PAYMENT_BANK_TFT_W:
                return $this->getTranslator()->trans('Virement bancaire en attente');
                break;
            case PaymentPlan::PAYMENT_BANK_TFT_V:
                return $this->getTranslator()->trans('Virement bancaire effectué');
                break;
            case PaymentPlan::PAYMENT_BANK_TFT_C:
                return $this->getTranslator()->trans('Virement bancaire annulé');
                break;
            case PaymentPlan::PAYMENT_CNL:
                return $this->getTranslator()->trans('Paiement annulé');
                break;
        }
    }
}