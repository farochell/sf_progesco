<?php
/**
 * sf_progesco
 *
 * emile.camara
 * 19/11/2019
 */

namespace App\Pedagogy\Service;


use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Pedagogy\Entity\SchoolYear;

/**
 * Class SchoolYearService
 *
 * @package App\Pedagogy\Service
 * 
 */
class SchoolYearService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton($this->getTranslator()->trans('Ajouter une année scolaire'), 'fa fa-plus', 'white-text text-lighten-4 light-green darken-4');
        $button->setUrl('schoolyear_add');
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
            $this->getTranslator()->trans('Date de début'),
            $this->getTranslator()->trans('Date de fin'),
            '',
            '',
        ];
        $table   = $this->getTable('schoolyear');
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(SchoolYear::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('label', $record->getLabel()));
                $row->addCells($this->getCell('startDate', $record->getStartDate()->format('d/m/Y')));
                $row->addCells($this->getCell('endDate', $record->getEndDate()->format('d/m/Y')));
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'schoolyear_upd', 'light-blue darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'schoolyear_del', 'red darken-3 white-text'));
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