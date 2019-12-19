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
use App\Pedagogy\Entity\Course;
use App\Pedagogy\Entity\Group;
use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;

/**
 * Class GroupService
 *
 * @package App\Pedagogy\Service
 *
 */
class GroupService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton("Ajouter un groupe", "fa fa-plus", "white-text text-lighten-4 light-green darken-4");
        $button->setUrl("group_add");
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [
            'Libellé',
            'Niveau',
            'Année scolaire',
            'Capacité d\'accueil',
            '',
            '',
            '',
        ];
        $table   = $this->getTable("group");
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Group::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("label", $record->getLabel()));
                $row->addCells($this->getCell("level", $record->getLevel()));
                $row->addCells($this->getCell("schoolyear", $record->getSchoolyear()));
                $row->addCells($this->getCell("effective", $record->getEffective()));
                
                $cell       = $this->getCell("upd", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Modifier", "group_upd", "light-blue darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
    
                $cell       = $this->getCell("cal", "", "cell-action");
                $cellAction = $this->getCellAction("cal", "link");
                $cellAction->setCellattribute($this->getCellAttribute("far fa-calendar-alt", "Emploi du temps", "group_schedule", "yellow darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell("del", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "group_del", "red darken-3 white-text"));
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
            'libelle'       => 'Libellé',
            'level'         => 'Niveau',
            'anneeScolaire' => 'Année scolaire',
            'nbEleves'      => 'Effectif maximum',
            '',
            '',
        ];
        $table   = $this->getTable("group");
        $table->addHeaders($headers);
        if ($this->getSchoolYearHelper()
                 ->getActiveYear()) {
            $records = $this->getEm()
                            ->getRepository(Group::class)
                            ->findBy([
                                'level'        => $this->getRequest()
                                                        ->get('level_id'),
                                'schoolyear' => $this->getSchoolYearHelper()
                                                        ->getActiveYear(),
                            ]);
        
            if ($records) {
                foreach ($records as $record) {
                    $row = $this->getRow($record->getId());
                    $row->addCells($this->getCell("label", $record->getLabel()));
                    $row->addCells($this->getCell("level", $record->getLevel()));
                    $row->addCells($this->getCell("schoolyear", $record->getSchoolyear()));
                    $row->addCells($this->getCell("effectif", $record->getEffective()));
                
                    // Set action cell
                    $cell       = $this->getCell("action", "", "cell-action");
                    $cellAction = $this->getCellAction("upd", "link");
                    // Add attribute
                    $params = [
                        'id'        => $record->getId(),
                        'grade_id' => $record->getGrade()
                                              ->getId(),
                    ];
                    $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Modifier", "group_upd", "btn-dark", "", $params));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
    
                    /*$cell       = $this->getCell("action");
                    $cellAction = $this->getCellAction("upd", "link");
                    // Add attribute
                    $params = [
                        'groupe_id' => $record->getId(),
                        'classe_id' => $record->getClasse()
                                              ->getId(),
                    ];
                    $cellAction->setCellattribute($this->getCellAttribute("fas fa-file-pdf", "Imprimer la liste de présence", "impression_groupe", "blue-grey", "", $params));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);*/
                
                    $cell       = $this->getCell("action", "", "cell-action");
                    $cellAction = $this->getCellAction("del", "link");
                    // Add attribute
                    $params = [
                        'id'        => $record->getId(),
                        'level_id' => $record->getLevel()
                                              ->getId(),
                    ];
                    $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Editer", "group_del", "bg-danger", "", $params));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
                
                    $table->addRows($row);
                }
            }
        }
    
        return [ 'table' => $table, 'pagination' => null ];
    }
    
    /**
     * @param Month $month
     *
     * @return mixed
     */
    public function getSchedules(Month $month)
    {
        $start = $month->getStartingDayFormated();
        $weeks = $month->getWeeks();
        $end   = (clone $start)->modify("+" . (5 + 7 * ($weeks - 1)) . " days");
        
        $pointages = $this->getEm()
                          ->getRepository(Course::class)
                          ->getCourseByGroupAndDate($start, $end, $this->getRequest()
                                                                         ->get("id"));
        
        return $pointages;
    }
}