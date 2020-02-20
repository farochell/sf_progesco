<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   22/11/2019
 * @time  :   17:12
 */

namespace App\Pedagogy\Service;


use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Pedagogy\Entity\Subject;

/**
 * Class SubjectService
 *
 * @package App\Pedagogy\Service
 *
 */
class SubjectService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton($this->getTranslator()->trans('Ajouter une matière'), 'fa fa-plus', 'white-text text-lighten-4 indigo lighten-1');
        $button->setUrl('subject_add');
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [
            $this->getTranslator()->trans( 'Code'),
            $this->getTranslator()->trans('Libellé'),
            $this->getTranslator()->trans('Spécialité'),
            '',
            '',
        ];
        $table   = $this->getTable('subject');
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Subject::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('code', $record->getCode()));
                $row->addCells($this->getCell('label', $record->getLabel()));
                $row->addCells($this->getCell('speciality', $record->getSpeciality()));
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'subject_upd', 'light-blue darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'subject_del', 'red darken-3 white-text'));
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