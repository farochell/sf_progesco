<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   15/01/2020
 * @time  :   14:33
 */

namespace App\Accounting\Service;

use App\Accounting\Entity\ExpenseLine;
use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;

/**
 * Class ExpenseLineService
 *
 * @package App\Accounting\Service
 *
 */
class ExpenseLineService extends ManagerService {
    /**
     * @return array
     */
    public function addButton() {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton(
                $this->getTranslator()->trans('Ajouter une dépense'), 'fa fa-plus', 'white-text text-lighten-4 indigo lighten-1'
            );
        $button->setUrl('expenseline_add');
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll() {
        $headers = [$this->getTranslator()->trans('Date'), $this->getTranslator()->trans('Type de dépense'), $this->getTranslator()->trans('Montant'),
                    $this->getTranslator()->trans('Statut'), '', '', '', ''];
        $table   = $this->getTable('expenseline');
        $table->addHeaders($headers);
        
        if ($this->getSchoolYearHelper()
                 ->getActiveYear()) {
            $records = $this->getEm()
                            ->getRepository(ExpenseLine::class)
                            ->findBy(
                                [
                                    'schoolYear' => $this->getSchoolYearHelper()
                                                         ->getActiveYear(),
                                ]
                            );
            
            if ($records) {
                foreach ($records as $record) {
                    $row = $this->getRow($record->getId());
                    $row->addCells(
                        $this->getCell(
                            'expensedate', $record->getExpenseDate()
                                                  ->format('d/m/Y')
                        )
                    );
                    $row->addCells($this->getCell('expenseType', $record->getExpenseType()));
                    $row->addCells($this->getCell('amount', $record->getAmount(), '', 'money'));
                    $row->addCells($this->getCell('status', $this->statusToString($record->getStatus())));
                    // Set action cell
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('edit', 'link');
                    // Add attribute
                    $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'expenseline_upd'));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                    
                    if ($record->getStatus() == ExpenseLine::INIT) {
                        $cell       = $this->getCell('action');
                        $cellAction = $this->getCellAction('change', 'ajax');
                        $cellAction->setCellattribute($this->getCellAttribute('fa fa-toggle-off', $this->getTranslator()->trans('Valider la dépense'), '', 'cyan darken-3 white-text'));
                        $cell->setCellAction($cellAction);
                        $row->addCells($cell);
                    }
                    
                    if ($record->getStatus() == ExpenseLine::VALIDED) {
                        $cell       = $this->getCell('action');
                        $cellAction = $this->getCellAction('change', 'ajax');
                        $cellAction->setCellattribute($this->getCellAttribute('fa fa-toggle-on', $this->getTranslator()->trans('Dépense validée'), '', 'deep-purple lighten-3 white-text'));
                        $cell->setCellAction($cellAction);
                        $row->addCells($cell);
                    }
                    
                    // Set action cell
                    // Set action cell
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('edit', 'link');
                    // Add attribute
                    $cellAction->setCellattribute(
                        $this->getCellAttribute('fa fa-list-alt', $this->getTranslator()->trans('Détail'), 'expenseline_detail', 'blue-grey darken-3 white-text', '')
                    );
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                    
                    // Set action cell
                    $cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('delete', 'link');
                    // Add attribute
                    $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'expenseline_del', 'bg-danger  white-text'));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                    
                    $table->addRows($row);
                }
            }
        }
        
        return ['table' => $table, 'pagination' => null];
        
    }
    
    public function find() {
        $request = $this->getRequest();
        $id      = $request->get('id');
        $record  = $this->getEm()
                        ->getRepository(ExpenseLine::class)
                        ->find($id);
        if (!$record) {
            throw new \Exception('Dépense non trouvée');
        }
        
        return $record;
    }
    
    /**
     * @param $status
     *
     * @return string
     */
    public function statusToString($status) {
        switch ($status) {
            case ExpenseLine::INIT:
                return$this->getTranslator()->trans( 'A valider');
                break;
            case ExpenseLine::VALIDED:
                return $this->getTranslator()->trans('Validée');
                break;
            case ExpenseLine::REFUSED:
                return $this->getTranslator()->trans('Refusée');
                break;
        }
    }
}