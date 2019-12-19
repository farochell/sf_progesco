<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   11/12/2019
 * @time  :   14:56
 */

namespace App\Teacher\Controller;


use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Teacher\Service\TeacherService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class Teacher
 *
 * @package App\Teacher\Controller
 * @Route("/admin")
 */
class Teacher extends ManagerController
{
    /**
     * TeacherController constructor.
     */
    public function __construct()
    {
        $this->setController('Teacher');
        $this->setBundle('App\\Teacher\\Controller');
        $this->setEntityNamespace('App\\Teacher');
        $this->setEntityName('Teacher');
        $this->setTag('@teacher');
    }
    
    /**
     * @Route("/teacher", name="teacher_homepage")
     *
     * @param TeacherService $teacherService
     *
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function home(TeacherService $teacherService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($teacherService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Professeurs', 'url' => 'speciality_homepage'];
        $this->setBreadcrumbs($breads);
        
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des professeurs");
        
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
     * @Route("/teacher/add", name="teacher_add")
     *
     *
     * @param OrmService  $ormService
     *
     * @param Breadcrumbs $breadcrumbs
     *
     * @return Response
     */
    public function add(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Professeurs', 'url' => 'teacher_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'teacher_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('teacher_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/teacher/update", name="teacher_upd")
     *
     *
     * @param OrmService  $ormService
     *
     * @param Breadcrumbs $breadcrumbs
     *
     * @return Response
     */
    public function update(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Professeurs', 'url' => 'teacher_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'teacher_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('teacher_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/teacher/delete", name="teacher_del")
     *
     * @param OrmService $ormService
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('teacher_homepage');
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/teacher/edit", name="teacher_edit")
     * @param TeacherService $teacherService
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function detail(TeacherService $teacherService, Breadcrumbs $breadcrumbs){
        $this->setService($teacherService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads = array();
        $breads[] = array('name'=>'Professeurs','url'=>'teacher_homepage');
        $breads[] = array('name'=>'Fiche','url'=>'teacher_edit');
        $this->setBreadcrumbs($breads);
        
        return parent::edit();
    }
}