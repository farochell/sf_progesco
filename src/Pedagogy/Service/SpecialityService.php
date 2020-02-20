<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   22/11/2019
 * @time  :   15:03
 */

namespace App\Pedagogy\Service;


use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Pedagogy\Entity\Speciality;

/**
 * Class SpecialityService
 *
 * @package App\Pedagogy\Service
 *
 */
class SpecialityService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton($this->getTranslator()->trans('Ajouter une spécialité'), 'fa fa-plus', 'white-text text-lighten-4 indigo lighten-1');
        $button->setUrl('speciality_add');
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
        $table   = $this->getTable('speciality');
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Speciality::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('label', $record->getLabel()));
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'speciality_upd', 'light-blue darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'speciality_del', 'red darken-3 white-text'));
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