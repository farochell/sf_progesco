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
use App\Pedagogy\Entity\Grade;
use App\Pedagogy\Entity\Group;
use App\Schooling\Entity\Registration;
use App\Schooling\Entity\RegistrationGroup;
use App\Schooling\Model\Student;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RegistrationService
 *
 * @package App\Schooling\Service
 *
 */
class RegistrationService extends ManagerService {
    /**
     * @return array
     */
    public function findAll() {
    
    }
    
    /**
     * @return array
     */
    public function getRegistrationsToBeValided() {
        $headers = [
            $this->getTranslator()->trans('Etudiant'),
            $this->getTranslator()->trans('Année scolaire'),
            $this->getTranslator()->trans('Classe'),
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
                                    'status'     => Registration::NOT_VALIDED,
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
                        'id' => $record->getId(),
                    ];
                    if ($record->getHasStateScholarship() == 0) {
                        $cellAction->setCellattribute(
                            $this->getCellAttribute("fa fa-plus", $this->getTranslator()->trans("Ajouter un paiement"), "payment_add", "green darken-3 white-text", "", $params)
                        );
                    } else {
                        $cellAction->setCellattribute(
                            $this->getCellAttribute(
                                "fa fa-plus", $this->getTranslator()->trans("Ajouter un paiement"), "scholarshippayment_add", "green darken-3 white-text", "", $params
                            )
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
    public function getRegistrationsByStudent($params) {
        $headers = [
            $this->getTranslator()->trans('Année scolaire'),
            $this->getTranslator()->trans('Classe'),
            $this->getTranslator()->trans('Filière'),
            $this->getTranslator()->trans('Statut'),
            $this->getTranslator()->trans('Boursier'),
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
                $cellAction->setCellattribute(
                    $this->getCellAttribute("fa fa-edit", $this->getTranslator()->trans("Modifier"), "group_upd", "light-blue darken-3 white-text",
                        "", $params)
                );
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell("action", "", "cell-action");
                $cellAction = $this->getCellAction("del", "link");
                // Add attribute
                $params = [
                    'id' => $record->getId(),
                ];
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", $this->getTranslator()->trans("Supprimer"),
                    "registration_del", "bg-danger", "", $params));
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
    public function getStatusLabel($statut_id) {
        switch ($statut_id) {
            case Registration::NOT_VALIDED:
                return $this->getTranslator()->trans('Non validée');
                break;
            case Registration::VALIDED:
                return $this->getTranslator()->trans('Validée');
                break;
            case Registration::CANCELED:
                return $this->getTranslator()->trans('Annulée');
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
                return $this->getTranslator()->trans('Oui');
                break;
            case 0:
                return $this->getTranslator()->trans('Non');
                break;
        }
    }
    
    /**
     * @param $response
     *
     * @return mixed
     */
    public function addInscriptionGroup($response) {
       try {
           // Get student list
           $students = $this->getRequest()->get('list');
           if ($students) {
               $students = explode(",", $students);
           }
           $group_id = $this->getRequest()->get('group_id');
           $group = $this->getEm()
                         ->getRepository(Group::class)
                         ->find($group_id);
           $schoolyear = $group->getSchoolyear();
           // Delete students from the group
           $this->getEm()
                ->getRepository(RegistrationGroup::class)
                ->removeRegistrationGroupByGroupId($group_id);
    
           if ($students) {
               foreach ($students as $student) {
                   // Get student registration
                   $registration = $this->getEm()
                                       ->getRepository(Registration::class)
                                       ->findOneBy(
                                           [
                                               'schoolYear' => $schoolyear->getId(),
                                               'student' => $student
                                           ]);
                   $em = $this->getEm();
                   $registration_group = new RegistrationGroup();
                   $registration_group->setRegistration($registration);
                   $registration_group->setGroup($group);
                   $em->persist($registration_group);
                   $em->flush();
               }
           }
    
           $response->setData(
               [
                   'status' => 'OK',
                   'message' => ''
               ]);
       } catch (\Exception $e) {
           $response->setData(
               [
                   'status' => 'KO',
                   'message' => 'Une erreur est intervenue!' .
                       $e->getMessage()
               ]);
       }
       
       return $response;
    }
    
    /**
     * @return JsonResponse
     */
    public function getStudentsByGrade() {
        $response = new JsonResponse();
        try {
            $gradeId = $this->getRequest()->get('grade_id');
            $groupId = $this->getRequest()->get('group_id');
            $grade = $this->getEm()->getRepository(Grade::class)->find($gradeId);
            $registrations = $this->getEm()->getRepository(Registration::class)->findStudentsNotRegistredInGroupByGrade($grade, $groupId);
            $serialized = null;
            $tab = [];
            if($registrations) {
                foreach ($registrations as $registration) {
                    $student = new Student();
                    $student->setId($registration->getStudent()->getId());
                    $student->setName($registration->getStudent()->getFirstname(). ' '. $registration->getStudent()->getLastname(). ' ('
                        .$registration->getStudent()->getMatricule(). ')');
                    $serialized = $this->getSerializer()->serialize($student, 'json');
                    $tab[] = $serialized;
                }
                
            }
            
            $response->setData([
                'status' => 'OK',
                'message' => $tab
            ]);
        } catch (\Exception $e) {
            $response->setData(
                [
                    'status' => 'KO',
                    'message' => 'Une erreur est intervenue!' .
                        $e->getMessage()
                ]);
        }
        
        return $response;
    }
}