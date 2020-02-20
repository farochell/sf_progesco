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
use App\Pedagogy\Entity\Grade;

/**
 * Class GradeService
 *
 * @package App\Pedagogy\Service
 * 
 */
class GradeService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton($this->getTranslator()->trans('Ajouter une classe'), 'fa fa-plus', 'white-text text-lighten-4 indigo lighten-1');
        $button->setUrl('grade_add');
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
            $this->getTranslator()->trans('Filière'),
            $this->getTranslator()->trans('Niveaux'),
            '',
            '',
            '',
        ];
        $table   = $this->getTable('grade');
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Grade::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('label', $record->getLabel()));
                $row->addCells($this->getCell('study', $record->getStudy()));
                $row->addCells($this->getCell('level', $record->getLevel()));
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'grade_upd', 'light-blue darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
    
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fas fa-eye', $this->getTranslator()->trans('Editer'), 'grade_edit', 'grey darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'grade_del', 'red darken-3 white-text'));
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
    
    /**
     * @return mixed
     * @throws \Exception
     */
    public function find()
    {
        $request = $this->getRequest();
        $id = $request->get('id');
       
        $record = $this->getEm()->getRepository(Grade::class)->find($id);
        if (!$record) {
            throw new \Exception('Grade with ID:' . $id . ' not found');
        }
        
        return $record;
    }
    
}