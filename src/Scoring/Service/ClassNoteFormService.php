<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   08/02/2020
 * @time  :   13:32
 */

namespace App\Scoring\Service;


use App\Manager\Service\ManagerService;
use App\Scoring\Entity\ClassNoteForm;

/**
 * Class ClassNoteFormService
 *
 * @package App\Scoring\Service
 *
 */
class ClassNoteFormService extends ManagerService {
    
    /**
     * @param $params
     *
     * @return array
     */
    public function getClassNoteFormsByClassNote($params) {
        $classNote = $params['id'];
        $headers   = [
            $this->getTranslator()->trans('Etudiant'),
            $this->getTranslator()->trans('Note'),
            '',
            '',
        ];
        $table     = $this->getTable('classnoteform');
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(ClassNoteForm::class)
                        ->findBy(['classNote' => $classNote]);
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('registration', $record->getRegistration()));
                $row->addCells($this->getCell('value', $record->getValue()));
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $params     = ['id' => $record->getId(), 'class_note_id' => $record->getClassNote()->getId(), 'registration_id' =>
                    $record->getRegistration()->getId()];
                $cellAction->setCellattribute(
                    $this->getCellAttribute(
                        'fa fa-edit', $this->getTranslator()->trans('Modifier'), 'classnoteform_upd',
                        'light-blue darken-3 white-text', '', $params
                    )
                );
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $params     = ['id' => $record->getId(), 'class_note_id' => $record->getClassNote()->getId()];
                $cellAction->setCellattribute(
                    $this->getCellAttribute(
                        'fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'classnoteform_del',
                        'red darken-3 white-text', '', $params
                    )
                );
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