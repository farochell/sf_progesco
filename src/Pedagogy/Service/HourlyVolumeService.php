<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   19/02/2020
 */

namespace App\Pedagogy\Service;


use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Pedagogy\Entity\HourlyVolume;

/**
 * Class HourlyVolumeService
 *
 * @package App\Pedagogy\Service
 *
 */
class HourlyVolumeService extends ManagerService {
    
    public function addButton() {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton(
                $this->getTranslator()->trans('Saisir un volume horaire'), 'fa fa-plus', 'white-text text-lighten-4 indigo lighten-1'
            );
        $button->setUrl('hourly_volume_add');
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    public function findAll() {
        $headers = [ $this->getTranslator()->trans('Matière'),
                     $this->getTranslator()->trans('Classe'),
                     $this->getTranslator()->trans('Période'),
                     $this->getTranslator()->trans('Année scolaire'),
                     $this->getTranslator()->trans('Heures à effectuer'),
                     $this->getTranslator()->trans('Heures effectuées'),
                     '', '' ];
        $table   = $this->getTable("tableAjax");
        $table->addHeaders($headers);
    
        if ($this->getSchoolYearHelper()
                 ->getActiveYear()) {
            $records = $this->getEm()
                            ->getRepository(HourlyVolume::class)
                            ->findBy(
                                [
                                    'schoolYear' => $this->getSchoolYearHelper()
                                                            ->getActiveYear(),
                                ]
                            );
            if ($records) {
                foreach ($records as $record) {
                    $row = $this->getRow($record->getId());
                    $row->addCells($this->getCell('subject', $record->getSubject()));
                    $row->addCells($this->getCell('grade', $record->getGrade()));
                    $row->addCells($this->getCell('semester', $record->getSemester()));
                    $row->addCells($this->getCell('schoolyear', $record->getSchoolYear()));
                    $row->addCells($this->getCell('totalHours', $record->getTotalHours()));
                    $row->addCells($this->getCell('hoursTaught', $record->getHoursTaught()));
    
                    $cell       = $this->getCell('action', '', 'cell-action');
                    $cellAction = $this->getCellAction('upd', 'link');
                    // Add attribute
                    $params = [
                        'id'       => $record->getId(),
                        'grade_id' => $record->getGrade()
                                             ->getId(),
                    ];
                    $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'hourly_volume_upd', 'btn-dark', '', $params));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
    
                    $cell       = $this->getCell('action', '', 'cell-action');
                    $cellAction = $this->getCellAction('del', 'link');
                    // Add attribute
                    $params = [
                        'id'       => $record->getId(),
                        'grade_id' => $record->getGrade()
                                             ->getId(),
                    ];
                    $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'hourly_volume_del', 'bg-danger white-text', '', $params));
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