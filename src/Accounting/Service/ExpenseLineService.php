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
class ExpenseLineService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton("Ajouter une dépense", "fa fa-plus", "white-text text-lighten-4 light-green darken-4");
        $button->setUrl("expenseline_add");
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [ 'Date', 'Type de dépense', 'Montant', 'Statut', '', '', '', '' ];
        $table   = $this->getTable("expenseline");
        $table->addHeaders($headers);
        
        if ($this->getSchoolYearHelper()
                 ->getActiveYear()) {
            $records = $this->getEm()
                            ->getRepository(ExpenseLine::class)
                            ->findBy([
                                'schoolYear' => $this->getSchoolYearHelper()
                                                        ->getActiveYear(),
                            ]);
            
            if ($records) {
                foreach ($records as $record) {
                    $row = $this->getRow($record->getId());
                    $row->addCells($this->getCell("expensedate", $record->getExpenseDate()
                                                                        ->format('d/m/Y')));
                    $row->addCells($this->getCell("expenseType", $record->getExpenseType()));
                    $row->addCells($this->getCell("amount", $record->getAmount(), '', 'money'));
                    $row->addCells($this->getCell("status", $this->statusToString($record->getStatus())));
                    // Set action cell
                    $cell       = $this->getCell("action");
                    $cellAction = $this->getCellAction("edit", "link");
                    // Add attribute
                    $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Modifier", "expenseline_upd"));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                    
                    if ($record->getStatus() == ExpenseLine::INIT) {
                        $cell       = $this->getCell("action");
                        $cellAction = $this->getCellAction("change", "ajax");
                        $cellAction->setCellattribute($this->getCellAttribute("fa fa-toggle-off", "Valider la dépense", "", "cyan darken-3"));
                        $cell->setCellAction($cellAction);
                        $row->addCells($cell);
                    }
                    
                    if ($record->getStatus() == ExpenseLine::VALIDED) {
                        $cell       = $this->getCell("action");
                        $cellAction = $this->getCellAction("change", "ajax");
                        $cellAction->setCellattribute($this->getCellAttribute("fa fa-toggle-on", "Dépense validée", "", "deep-purple lighten-3"));
                        $cell->setCellAction($cellAction);
                        $row->addCells($cell);
                    }
                    
                    // Set action cell
                    // Set action cell
                    $cell       = $this->getCell("action");
                    $cellAction = $this->getCellAction("edit", "link");
                    // Add attribute
                    $cellAction->setCellattribute($this->getCellAttribute("fa fa-list-alt", "Détail", "expenseline_detail", "blue-grey darken-3", ""));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                    
                    // Set action cell
                    $cell       = $this->getCell("action");
                    $cellAction = $this->getCellAction("delete", "link");
                    // Add attribute
                    $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "expenseline_del", "bg-danger"));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                    
                    $table->addRows($row);
                }
            }
        }
        
        return [ 'table' => $table, 'pagination' => null ];
        
    }
    
    public function find(){
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
    public function statusToString($status)
    {
        switch ($status) {
            case ExpenseLine::INIT:
                return "A valider";
                break;
            case ExpenseLine::VALIDED:
                return "Validé";
                break;
            case ExpenseLine::REFUSED:
                return "Refusé";
                break;
        }
    }
}