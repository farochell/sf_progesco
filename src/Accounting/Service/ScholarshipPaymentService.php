<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   02/01/2020
 * @time  :   17:42
 */

namespace App\Accounting\Service;


use App\Accounting\Entity\ScholarshipPayment;
use App\Accounting\Entity\ScholarshipPaymentPlan;
use App\Manager\Service\ManagerService;
use App\Manager\Service\OrmService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * Class ScholarshipPaymentService
 *
 * @package App\Accounting\Service
 * 
 */
class ScholarshipPaymentService extends ManagerService
{
    /**
     * @return array
     */
    public function getOpenPayments() {
        $headers = [$this->getTranslator()->trans('Référence'), $this->getTranslator()->trans('Etudiant'), $this->getTranslator()->trans('Frais de scolarite'), $this->getTranslator()->trans('Solde'), ''];
        $table = $this->getTable('openpayment');
        $table->addHeaders($headers);
        if ($this->getSchoolYearHelper()->getActiveYear()) {
            $records = $this->getEm()->getRepository(ScholarshipPayment::class)->getOpenPayements($this->getSchoolYearHelper()->getActiveYear());
            
            if ($records) {
                foreach ($records as $record) {
                    $row = $this->getRow($record->getId());
                    $row->addCells($this->getCell('reference', $record->getReference()));
                    $row->addCells($this->getCell('etudiant', $record->getRegistration()->getStudent()));
                    $row->addCells($this->getCell('montant', $record->getTuition(), '', 'money'));
                    $row->addCells($this->getCell('solde', $record->getBalance(), '', 'money'));
                    
                    $cell = $this->getCell('action');
                    $cellAction = $this->getCellAction('detail', 'link');
                    
                    $cellAction->setCellattribute($this->getCellAttribute('fas fa-eye', $this->getTranslator()->trans('Détail'), 'scholarshippayment_edit', 'grey darken-3 white-text'));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                    
                    $table->addRows($row);
                }
            }
        }
        
        return ['table' => $table, 'pagination' => null];
    }
    
    /**
     * @return array
     */
    public function getClosedPayments() {
        $headers = [$this->getTranslator()->trans('Référence'), $this->getTranslator()->trans('Etudiant'), $this->getTranslator()->trans('Frais de scolarite'), $this->getTranslator()->trans('Solde'), ''];
        $table = $this->getTable('openpayment');
        $table->addHeaders($headers);
        if ($this->getSchoolYearHelper()->getActiveYear()) {
            $records = $this->getEm()->getRepository(ScholarshipPayment::class)->getClosedPayments($this->getSchoolYearHelper()->getActiveYear());
        
            if ($records) {
                foreach ($records as $record) {
                    $row = $this->getRow($record->getId());
                    $row->addCells($this->getCell('reference', $record->getReference()));
                    $row->addCells($this->getCell('etudiant', $record->getRegistration()->getStudent()));
                    $row->addCells($this->getCell('montant', $record->getTuition(), '', 'money'));
                    $row->addCells($this->getCell('solde', $record->getBalance(), '', 'money'));
                
                    $cell = $this->getCell('action');
                    $cellAction = $this->getCellAction('detail', 'link');
                
                    $cellAction->setCellattribute($this->getCellAttribute('fas fa-eye', $this->getTranslator()->trans('Détail'), 'scholarshippayment_edit', 'grey darken-3 white-text'));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                
                    $table->addRows($row);
                }
            }
        }
    
        return ['table' => $table, 'pagination' => null];
    }
    
    /**
     * @return mixed
     * @throws \Exception
     */
    public function find(){
        $request = $this->getRequest();
        $id      = $request->get('id');
        $record  = $this->getEm()
                        ->getRepository(ScholarshipPayment::class)
                        ->find($id);
        if (!$record) {
            throw new \Exception('Paiement non trouvé');
        }
        
        return $record;
    }
    
   
}