<?php
/**
 * sf_progesco
 *
 * @author:   emile.camara
 * @date  :   27/11/2019
 * @time  :   22:06
 */

namespace App\Pedagogy\Service;

use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Pedagogy\Entity\Semester;

/**
 * Class SemesterService
 *
 * @package App\Pedagogy\Service
 *
 */
class SemesterService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   = $fabrique->createButton("Ajouter une période", "fa fa-plus", "white-text text-lighten-4 light-green darken-4");
        $button->setUrl("semester_add");
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
            'Date de début',
            'Date de fin',
            'Niveau',
            '',
            '',
        ];
        $table   = $this->getTable("semester");
        $table->addHeaders($headers);
    
        if ($this->getSchoolYearHelper()
                 ->getActiveYear()) {
            $records = $this->getEm()
                            ->getRepository(Semester::class)
                            ->findBy([
                                'schoolyear' => $this->getSchoolYearHelper()
                                                     ->getActiveYear(),
                            ]);
    
            if ($records) {
                foreach ($records as $record) {
                    $row = $this->getRow($record->getId());
                    $row->addCells($this->getCell("label", $record->getLabel()));
                    $row->addCells($this->getCell("startDate", $record->getStartDate()->format('d/m/Y')));
                    $row->addCells($this->getCell("endDate", $record->getEndDate()->format('d/m/Y')));
                    $row->addCells($this->getCell("level", $record->getLevel()));
            
                    $cell       = $this->getCell("upd", "", "cell-action");
                    $cellAction = $this->getCellAction("upd", "link");
                    $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Modifier", "semester_upd", "light-blue darken-3 white-text"));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
            
                    $cell       = $this->getCell("del", "", "cell-action");
                    $cellAction = $this->getCellAction("upd", "link");
                    $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "semester_del", "red darken-3 white-text"));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
            
                    $table->addRows($row);
                }
            }
            
        }
        
        return [
            'table'      => $table,
            'pagination' => null,
        ];
    }
}