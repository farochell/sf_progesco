<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 17/11/2019
 */

namespace App\Pedagogy\Service;


use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Pedagogy\Entity\CoursePeriod;

/**
 * Class CoursePeriodService
 *
 * @package App\Pedagogy\Service
 *
 */
class CoursePeriodService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton() {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton(
                $this->getTranslator()->trans('Ajouter un type de vacation'), 'fa fa-plus', 'white-text text-lighten-4 indigo lighten-1'
            );
        $button->setUrl('courseperiod_add');
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
            '',
            '',
        ];
        $table   = $this->getTable('courseperiod');
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(CoursePeriod::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('label', $record->getLabel()));
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'courseperiod_upd', 'light-blue darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
    
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'),
                    'courseperiod_del', 'red darken-3 white-text'));
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