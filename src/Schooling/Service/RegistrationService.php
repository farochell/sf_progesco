<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   31/12/2019
 * @time  :   13:25
 */

namespace App\Schooling\Service;


use App\Manager\Service\ManagerService;
use App\Schooling\Entity\Registration;

/**
 * Class RegistrationService
 *
 * @package App\Schooling\Service
 *
 */
class RegistrationService extends ManagerService
{
    /**
     * @return array
     */
    public function findAll()
    {
    
    }
    
    /**
     * @return array
     */
    public function getRegistrationsToBeValided(){
        $headers = [
            'Etudiant',
            'Année scolaire',
            'Classe',
            '',
            '',
        ];
        $table   = $this->getTable("registration");
        $table->addHeaders($headers);
    
        if ($this->getSchoolYearHelper()
                 ->getActiveYear()) {
            $records = $this->getEm()
                            ->getRepository(Registration::class)
                            ->findBy(
                                [
                                    'schoolYear' => $this->getSchoolYearHelper()
                                                         ->getActiveYear(),
                                    'status' => Registration::NOT_VALIDED
                                ]
                            );
            if ($records) {
                foreach ($records as $record) {
                    $row = $this->getRow($record->getId());
                    $row->addCells($this->getCell("student", $record->getStudent()));
                    $row->addCells($this->getCell("schoolyear", $record->getSchoolYear()));
                    $row->addCells($this->getCell("grade", $record->getGrade()));
                    
        
                    // Set action cell
                    $cell       = $this->getCell("action", "", "cell-action");
                    $cellAction = $this->getCellAction("upd", "link");
                    // Add attribute
                    $params = [
                        'id'       => $record->getId(),
                    ];
                    if($record->getHasStateScholarship() == 0) {
                        $cellAction->setCellattribute(
                            $this->getCellAttribute("fa fa-plus", "Ajouter un payement", "payment_add", "green darken-3 white-text", "", $params)
                        );
                    } else {
                        $cellAction->setCellattribute(
                            $this->getCellAttribute("fa fa-plus", "Ajouter un payement", "scholarshippayment_add", "green darken-3 white-text", "", $params)
                        );
                    }
                    
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
        
                    
        
                    $cell       = $this->getCell("action", "", "cell-action");
                    $cellAction = $this->getCellAction("del", "link");
                    // Add attribute
                    $params = [
                        'id' => $record->getId(),
                    ];
                    $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "group_del", "bg-danger", "", $params));
                    $cell->setCellAction($cellAction);
                    $row->addCells($cell);
        
                    $table->addRows($row);
                }
            }
        }
    
        return ['table' => $table, 'pagination' => null];
        
    }
    
    /**
     * @param $params
     *
     * @return array
     */
    public function getRegistrationsByStudent($params)
    {
        $headers = [
            'Année scolaire',
            'Classe',
            'Filière',
            'Statut',
            'Boursier',
            '',
            '',
        ];
        $table   = $this->getTable("registration");
        $table->addHeaders($headers);
        
        $records = $this->getEm()
                        ->getRepository(Registration::class)
                        ->findBy(
                            [
                                'student' => $params['id'],
                            ]
                        );
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("schoolyear", $record->getSchoolYear()));
                $row->addCells($this->getCell("grade", $record->getGrade()));
                $row->addCells($this->getCell("grade", $record->getGrade()->getStudy()));
                $row->addCells($this->getCell('status', $this->getStatusLabel($record->getStatus())));
                $row->addCells($this->getCell('hasscholarship', $this->getScholarshipLabel($record->getHasStateScholarship())));
                
                // Set action cell
                $cell       = $this->getCell("action", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                // Add attribute
                $params = [
                    'id'       => $record->getId(),
                    'grade_id' => $record->getGrade()
                                         ->getId(),
                ];
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Modifier", "group_upd", "light-blue darken-3 white-text", "", $params));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
               
                $cell       = $this->getCell("action", "", "cell-action");
                $cellAction = $this->getCellAction("del", "link");
                // Add attribute
                $params = [
                    'id' => $record->getId(),
                ];
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "registration_del", "bg-danger", "", $params));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $table->addRows($row);
            }
        }
        
        return ['table' => $table, 'pagination' => null];
    }
    
    /**
     * @param $statut_id
     *
     * @return string
     */
    public function getStatusLabel($statut_id)
    {
        switch ($statut_id) {
            case Registration::NOT_VALIDED:
                return 'Non validée';
                break;
            case Registration::VALIDED:
                return 'Validée';
                break;
            case Registration::CANCELED:
                return 'Annulée';
                break;
        }
    }
    
    /**
     * @param $hasStateScholarship
     *
     * @return string
     */
    public function getScholarshipLabel($hasStateScholarship) {
        switch ($hasStateScholarship) {
            case 1:
                return 'Oui';
                break;
            case 0:
                return 'Non';
                break;
        }
    }
}