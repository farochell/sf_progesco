<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 17/11/2019
 */

namespace App\Pedagogy\Service;


use App\Pedagogy\Entity\Study;
use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;

/**
 * Class StudyService
 *
 * @package App\Pedagogy\Service
 *
 */
class StudyService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton($this->getTranslator()->trans('Ajouter une filière'), 'fa fa-plus', 'white-text text-lighten-4 indigo lighten-1');
        $button->setUrl('study_add');
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
        $table   = $this->getTable('study');
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Study::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('label', $record->getLabel()));
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'study_upd', 'light-blue darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
    
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'study_del', 'red darken-3 white-text'));
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