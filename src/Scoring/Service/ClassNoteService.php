<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/02/2020
 * @time  :   11:55
 */

namespace App\Scoring\Service;


use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Schooling\Entity\Registration;
use App\Scoring\Entity\ClassNote;
use App\Scoring\Entity\ClassNoteForm;
use App\Scoring\Entity\TypeOfRating;

/**
 * Class ClassNoteService
 *
 * @package App\Scoring\Service
 *
 */
class ClassNoteService extends ManagerService {
    /**
     * @return array
     */
    public function addButton() {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton($this->getTranslator()->trans('Ajouter une note'), 'fa fa-plus', 'white-text text-lighten-4 light-green darken-4');
        $button->setUrl('classnote_add');
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function getHomeworkNote() {
        $headers = [
            $this->getTranslator()->trans('Type'),
            $this->getTranslator()->trans('Libellé'),
            $this->getTranslator()->trans('Matière'),
            $this->getTranslator()->trans('Periode'),
            $this->getTranslator()->trans('Enseignant'),
            $this->getTranslator()->trans('Classe'),
            '',
            '',
            '',
        ];
        $table   = $this->getTable('classnote');
        $table->addHeaders($headers);
        $typeOfRating = $this->getEm()->getRepository(TypeOfRating::class)->findOneBy(['label' => 'Devoir']);
        $records = $this->getEm()
                        ->getRepository(ClassNote::class)
                        ->findBy(['typeOfRating' => $typeOfRating->getId() ]);
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('typeofrating', $record->getTypeOfRating()));
                $row->addCells($this->getCell('label', $record->getLabel()));
                $row->addCells($this->getCell('subject', $record->getSubject()));
                $row->addCells($this->getCell('periode', $record->getSemester()));
                $row->addCells($this->getCell('teacher', $record->getTeacher()));
                $row->addCells($this->getCell('grade', $record->getGrade()));
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'classnote_upd', 'light-blue darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fas fa-eye', $this->getTranslator()->trans('Détail'), 'classnote_form', 'grey darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'classnote_del', 'red darken-3 white-text'));
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
     * @return array
     */
    public function getExaminationScore() {
        $headers = [
            $this->getTranslator()->trans('Type'),
            $this->getTranslator()->trans('Libellé'),
            $this->getTranslator()->trans('Matière'),
            $this->getTranslator()->trans('Periode'),
            $this->getTranslator()->trans('Enseignant'),
            $this->getTranslator()->trans('Classe'),
            '',
            '',
            '',
        ];
        $table   = $this->getTable('classnote');
        $table->addHeaders($headers);
        $typeOfRating = $this->getEm()->getRepository(TypeOfRating::class)->findOneBy(['label' => 'Examen']);
        $records = $this->getEm()
                        ->getRepository(ClassNote::class)
                        ->findBy(['typeOfRating' => $typeOfRating->getId() ]);
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('typeofrating', $record->getTypeOfRating()));
                $row->addCells($this->getCell('label', $record->getLabel()));
                $row->addCells($this->getCell('subject', $record->getSubject()));
                $row->addCells($this->getCell('periode', $record->getSemester()));
                $row->addCells($this->getCell('teacher', $record->getTeacher()));
                $row->addCells($this->getCell('grade', $record->getGrade()));
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'classnote_upd', 'light-blue darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fas fa-eye', $this->getTranslator()->trans('Détail'), 'classnote_form', 'grey darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'classnote_del', 'red darken-3 white-text'));
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
    public function find() {
        $request = $this->getRequest();
        $id      = $request->get('id');
        $record  = $this->getEm()
                        ->getRepository(ClassNote::class)
                        ->find($id);
        if (!$record) {
            $this->getLogger()->error('ClassNote ID not found :'.$id);
            throw new \Exception('ClassNote ID not found :'.$id);
        }
        
        return $record;
    }
    
    /**
     *
     */
    public function setClassNoteFormByGradeId() {
        $classNote = $this->getEm()->getRepository(ClassNote::class)->find($this->getRequest()->get('id'));
        $grade     = $classNote->getGrade();
        $registrations = $this->getEm()->getRepository(Registration::class)->findBy(['grade' => $grade->getId(), 'status' => Registration::VALIDED]);
       try {
           foreach($registrations as $registration) {
               // we check if there is a note registered
               $classNoteForm = $this->getEm()->getRepository(ClassNoteForm::class)->findOneBy(['classNote' => $classNote, 'registration' =>
                   $registration] );
               if(!$classNoteForm) {
                   $classNoteForm = new ClassNoteForm();
                   $classNoteForm->setRegistration($registration);
                   $classNoteForm->setValue(0.0);
                   $classNoteForm->setClassNote($classNote);
                   $this->getEm()->persist($classNoteForm);
                   $this->getEm()->flush();
                   $this->getLogger()->info('New classNoteForm added');
               }
        
           }
       } catch (\Exception $e) {
           $this->getLogger()->error('Error:' . $e->getMessage());
       }
    }
}