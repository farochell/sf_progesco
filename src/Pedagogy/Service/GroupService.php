<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   21/11/2019
 * @time  :   14:14
 */

namespace App\Pedagogy\Service;

use App\Calendar\Model\Month;
use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Pedagogy\Entity\Course;
use App\Pedagogy\Entity\Grade;
use App\Pedagogy\Entity\Group;
use App\Schooling\Entity\RegistrationGroup;

/**
 * Class GroupService
 *
 * @package App\Pedagogy\Service
 *
 */
class GroupService extends ManagerService {
    /**
     * @return array
     */
    public function addButton() {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton($this->getTranslator()->trans('Ajouter un groupe'), 'fa fa-plus', 'white-text text-lighten-4 indigo lighten-1');
        $button->setUrl('group_add');
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll() {
        $headers = [
            $this->getTranslator()->trans('Libellé'),
            $this->getTranslator()->trans('Niveau'),
            $this->getTranslator()->trans('Année scolaire'),
            $this->getTranslator()->trans('Capacité d\'accueil'),
            $this->getTranslator()->trans('Effectif'),
            '',
            '',
            '',
            '',
        ];
        $table   = $this->getTable('group');
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Group::class)
            ->findBy([
                'schoolyear' => $this->getSchoolYearHelper()
                                        ->getActiveYear(),
            ]);
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('label', $record->getLabel()));
                $row->addCells($this->getCell('level', $record->getLevel()));
                $row->addCells($this->getCell('schoolyear', $record->getSchoolyear()));
                $row->addCells($this->getCell('effective', $record->getEffective()));
                $row->addCells($this->getCell('effective', $record->getRegistrationgroupsCount()));
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'group_upd', 'light-blue darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('cal', '', 'cell-action');
                $cellAction = $this->getCellAction('cal', 'link');
                $cellAction->setCellattribute(
                    $this->getCellAttribute('far fa-calendar-alt', $this->getTranslator()->trans('Emploi du temps'), 'group_schedule', 'yellow darken-3 white-text')
                );
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('action');
                $cellAction = $this->getCellAction('edit', 'link');
                // Add attribute
                $params = [
                    'id' => $record->getId(),
                ];
                $cellAction->setCellattribute(
                    $this->getCellAttribute(
                        'fas fa-eye', 'Editer', 'group_form', 'blue-grey darken-3 white-text', '',
                        $params
                    )
                );
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'group_del', 'red darken-3 white-text'));
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
    public function getByLevel() {
        $headers = [
            'libelle'       => $this->getTranslator()->trans('Libellé'),
            'level'         => $this->getTranslator()->trans('Niveau'),
            'anneeScolaire' => $this->getTranslator()->trans('Année scolaire'),
            'nbEleves'      => $this->getTranslator()->trans('Effectif maximum'),
            
            '',
            '',
        ];
        $table   = $this->getTable('group');
        $table->addHeaders($headers);
        if ($this->getSchoolYearHelper()
                 ->getActiveYear()) {
            $records = $this->getEm()
                            ->getRepository(Group::class)
                            ->findBy(
                                [
                                    'level'      => $this->getRequest()
                                                         ->get('level_id'),
                                    'schoolyear' => $this->getSchoolYearHelper()
                                                         ->getActiveYear(),
                                ]
                            );
            
            if ($records) {
                foreach ($records as $record) {
                    $row = $this->getRow($record->getId());
                    $row->addCells($this->getCell('label', $record->getLabel()));
                    $row->addCells($this->getCell('level', $record->getLevel()));
                    $row->addCells($this->getCell('schoolyear', $record->getSchoolyear()));
                    $row->addCells($this->getCell('effectif', $record->getEffective()));
                    
                    // Set action cell
                    $cell       = $this->getCell('action', '', 'cell-action');
                    $cellAction = $this->getCellAction('upd', 'link');
                    // Add attribute
                    $params = [
                        'id'       => $record->getId(),
                        'grade_id' => $record->getGrade()
                                             ->getId(),
                    ];
                    $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'group_upd', 'btn-dark', '', $params));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                    
                    /*$cell       = $this->getCell('action');
                    $cellAction = $this->getCellAction('upd', 'link');
                    // Add attribute
                    $params = [
                        'groupe_id' => $record->getId(),
                        'classe_id' => $record->getClasse()
                                              ->getId(),
                    ];
                    $cellAction->setCellattribute($this->getCellAttribute('fas fa-file-pdf', 'Imprimer la liste de présence', 'impression_groupe', 'blue-grey', '', $params));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);*/
                    
                    $cell       = $this->getCell('action', '', 'cell-action');
                    $cellAction = $this->getCellAction('del', 'link');
                    // Add attribute
                    $params = [
                        'id'       => $record->getId(),
                        'level_id' => $record->getLevel()
                                             ->getId(),
                    ];
                    $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'group_del', 'bg-danger white-text', '', $params));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                    
                    $table->addRows($row);
                }
            }
        }
        
        return ['table' => $table, 'pagination' => null];
    }
    
    /**
     * @param Month $month
     *
     * @return mixed
     */
    public function getSchedules(Month $month) {
        $start = $month->getStartingDayFormated();
        $weeks = $month->getWeeks();
        $end   = (clone $start)->modify('+'.(5 + 7 * ($weeks - 1)).' days');
        
        $pointages = $this->getEm()
                          ->getRepository(Course::class)
                          ->getCourseByGroupAndDate(
                              $start, $end, $this->getRequest()
                                                 ->get('id')
                          );
        
        return $pointages;
    }
    
    /**
     * @return mixed
     * @throws \Exception
     */
    public function find() {
        $request = $this->getRequest();
        $id      = $request->get('id');
        $record  = $this->getEm()
                        ->getRepository(Group::class)
                        ->find($id);
        if (!$record) {
            $this->getLogger()->error('Group ID not found :'.$id);
            throw new \Exception('Group ID not found :'.$id);
        }
        
        return $record;
    }
    
    /**
     * @return array
     */
    public function getGroupeInfo() {
        $tab   = [];
        $id    = $this->getRequest()->get('id');
        $group = $this->getEm()->getRepository(Group::class)->find($id);
        $level = $group->getLevel();
        // retrieve grades of the level
        $grades = $this->getEm()->getRepository(Grade::class)->findByLevel($level);
        // retrieve students registered in this group
        $registrations = $this->getEm()->getRepository(RegistrationGroup::class)->findByGroup($id);
        // retrieve students of the level
        $studentsNotRegistered = $this->getEm()->getRepository(RegistrationGroup::class)->getStudentsNotRegistredInGroup($id, $level->getId());
        $tab['registered']     = $registrations;
        $tab['notregistered']  = $studentsNotRegistered;
        $tab['grades']         = $grades;
        
        return $tab;
    }
    
    
    
}