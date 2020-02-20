<?php
/**
 * sf_progesco
 *
 * emile.camara
 * 18/11/2019
 */

namespace App\Configuration\Service;


use App\Configuration\Entity\MaritalStatus;
use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;

/**
 * Class MaritalStatusService
 *
 * @package App\Configuration\Service
 *
 */
class MaritalStatusService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink;
        $button   =
            $fabrique->createButton($this->getTranslator()->trans('Ajouter une situation matrimoniale'), 'fa fa-plus', 'white-text text-lighten-4 indigo lighten-1');
        $button->setUrl('marital-status_add');
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [
            $this->getTranslator()->trans('Libellé'),
            ''
        ];
        $table = $this->getTable('maritalStatus');
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(MaritalStatus::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('label', $record->getLabel()));
                
                $cell = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 
                    'marital-status_upd', 'light-blue darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $table->addRows($row);
            }
        }
        
        return [
            'table' => $table,
            'pagination' => null
        ];
    }
}