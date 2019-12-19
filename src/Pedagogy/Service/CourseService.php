<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   28/11/2019
 * @time  :   15:40
 */

namespace App\Pedagogy\Service;


use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Pedagogy\Entity\Course;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CourseService
 *
 * @package App\Pedagogy\Service
 * 
 */
class CourseService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton("Planifier un cours", "fa fa-plus", "white-text text-lighten-4 light-green darken-4");
        $button->setUrl("course_add");
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [
            'Matière',
            'Groupe(s)',
            'Période',
            'Date du cours',
            'Heure de début',
            'Heure de fin',
            'Salle',
            '',
            '',
        ];
        $table   = $this->getTable("course");
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Course::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("teaching", $record->getTeaching()));
                $row->addCells($this->getCell("group", $this->splitGroups($record->getGroups())));
                $row->addCells($this->getCell("semester", $record->getSemester()));
                $row->addCells($this->getCell("courseDate", $record->getCourseDate()->format("d/m/Y")));
                $row->addCells($this->getCell("startDate", $record->getStartHour()->format("H:i")));
                $row->addCells($this->getCell("endDate", $record->getEndHour()->format("H:i")));
                $row->addCells($this->getCell("classroom", $record->getClassroom()));
                
                $cell       = $this->getCell("upd", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Modifier", "course_upd", "light-blue darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell("del", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "course_del", "red darken-3 white-text"));
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
     * @param $groups
     *
     * @return string
     */
    public function splitGroups($groups) {
        $tab = [];
        foreach($groups as $group) {
            $tab [] = $group->getLabel();
        }
        
        return implode(",", $tab);
    }
    
}