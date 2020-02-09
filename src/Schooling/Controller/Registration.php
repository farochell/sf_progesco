<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   31/12/2019
 * @time  :   13:03
 */

namespace App\Schooling\Controller;

use App\Manager\Controller\ManagerController;
use App\Manager\Util\Constant;
use App\Schooling\Service\RegistrationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\Service\OrmService;

/**
 * Class Registration
 *
 * @package App\Schooling\Controller
 * @Route("/admin")
 */
class Registration extends ManagerController {
    /**
     * Registration constructor.
     *
     * @param OrmService          $ormService
     * @param RegistrationService $registrationService
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     */
    public function __construct(
        OrmService $ormService,
        RegistrationService $registrationService,
        Breadcrumbs $breadcrumbs,
        TranslatorInterface $translator
    ) {
        $this->setOrmService($ormService);
        $this->setService($registrationService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setTranslator($translator);
        $this->setController('Registration');
        $this->setBundle('App\\Schooling\\Controller');
        $this->setEntityNamespace('App\\Schooling');
        $this->setEntityName('Registration');
        $this->setTag('@schooling');
    }
    
    /**
     * @Route("/registrations", name="registration_homepage")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_REGISTRATION_SHOW')")
     * @param RegistrationService $registrationService
     *
     * @param Breadcrumbs         $breadcrumbs
     *
     * @return Response
     */
    public function home() {
        
        $breads   = [];
        $breads[] = ['name' => 'Inscriptions', 'url' => 'registration_homepage'];
        $this->setBreadcrumbs($breads);
        
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Inscriptions");
        
        return parent::index();
    }
    
    /**
     * @Route("/registrations/to-be-validated", name="registration_to_be_validated_homepage")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_REGISTRATION_SHOW') or is_granted('ROLE_ACCOUNTING_SHOW')")
     * @return Response
     */
    public function registrationToBeValided() {
        $breads   = [];
        $breads[] = ['name' => 'Inscriptions à valider', 'url' => 'registration_homepage'];
        $this->setBreadcrumbs($breads);
        
        $this->addAction(['function' => 'getRegistrationsToBeValided', 'params' => []]);
        $this->setCardTitle("Liste des inscriptions à valider");
        
        return parent::index();
    }
    
    /**
     * @param $params
     *
     * @return Response
     */
    public function show($params) {
        return parent::customFunction("findAll", $params);
    }
    
    /**
     * @return Response
     */
    public function getRegistrationsToBeValided() {
        return parent::customFunction("getRegistrationsToBeValided");
    }
    
    /**
     * @param $params
     *
     * @return Response
     */
    public function getRegistrationsByStudent($params) {
        return parent::customFunction("getRegistrationsByStudent", $params);
    }
    
    /**
     * @Route("/registrations/add", name="registration_add")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_REGISTRATION_ADD')")
     * @return JsonResponse|RedirectResponse|Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Inscriptions', 'url' => 'registration_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'registration_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('student_edit', ['id' => $this->getRequest()->get('student-id')]);
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/registrations/delete", name="registration_del")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_REGISTRATION_DEL')")
     * @return JsonResponse|RedirectResponse|void
     */
    public function delete() {
    
    }
    
    /**
     * @Route("/registrations/group/add", name="registrationgroup_add", options={"expose"=true})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_REGISTRATION_ADD')")
     */
    public function addRegistrationGroup() {
        $response = new JsonResponse();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') && !$this->get('security.authorization_checker')->isGranted(
                'ROLE_REGISTRATION_GROUP_ADD'
            )) {
            $response->setData(
                ["statut"  => "KO",
                 "message" => "Vous n'avez pas les droits nécessaires pour effectuer cette action. Veuillez contacter l'administrateur."]
            );
        } else {
            $response = $this->getService()->addInscriptionGroup($response);
        }
        
        
        return $response;
    }
    
    /**
     * @Route("/registrations/grade/students", name="get_students_by_grade", options={"expose"=true})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_REGISTRATION_ADD')")
     */
    public function getStudentsByGrade() {
        return $this->getService()->getStudentsByGrade();
    }
}