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
use App\Schooling\Service\RegistrationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
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
class Registration extends ManagerController
{
    /**
     * Registration constructor.
     *
     * @param RegistrationService $registrationService
     */
    public function __construct(RegistrationService $registrationService)
    {
        $this->setService($registrationService);
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
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function home(RegistrationService $registrationService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($registrationService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Inscriptions', 'url' => 'registration_homepage'];
        $this->setBreadcrumbs($breads);
        
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Inscriptions");
        
        return parent::index();
    }
    
    /**
     * @Route("/registrations/to-be-valided", name="registration_to_be_valided_homepage")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_REGISTRATION_SHOW') or is_granted('ROLE_ACCOUNTING_SHOW')")
     * @param RegistrationService $registrationService
     *
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function registrationToBeValided(RegistrationService $registrationService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($registrationService);
        $this->setBreadcrumbService($breadcrumbs);
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
    public function show($params)
    {
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
    public function getRegistrationsByStudent($params)
    {
        return parent::customFunction("getRegistrationsByStudent", $params);
    }
    
    /**
     * @Route("/registrations/add", name="registration_add")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_REGISTRATION_ADD')")
     * @param OrmService  $ormService
     * @param Breadcrumbs $breadcrumbs
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    public function add(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
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
}