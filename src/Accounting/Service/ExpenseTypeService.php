<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   15/01/2020
 * @time  :   14:09
 */

namespace App\Accounting\Service;


use App\Accounting\Entity\ExpenseType;
use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;

/**
 * Class ExpenseTypeService
 *
 * @package App\Accounting\Service
 * 
 */
class ExpenseTypeService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton("Ajouter un type de dépense", "fa fa-plus", "white-text text-lighten-4 light-green darken-4");
        $button->setUrl("expensetype_add");
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [
            'Libellé',
            '',
            '',
        ];
        $table   = $this->getTable("expensetype");
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(ExpenseType::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("label", $record->getLabel()));
                
                $cell       = $this->getCell("upd", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Modifier", "expensetype_upd", "light-blue darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell("del", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "expensetype_del", "red darken-3 white-text"));
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