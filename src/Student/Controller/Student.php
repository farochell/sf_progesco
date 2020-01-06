<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   27/12/2019
 * @time  :   14:13
 */

namespace App\Student\Controller;


use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Student\Service\StudentService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Student
 *
 * @package App\Student\Controller
 * @Route("/admin")
 */
class Student extends ManagerController
{
    /**
     * Student constructor.
     */
    public function __construct()
    {
        $this->setController('Student');
        $this->setBundle('App\\Student\\Controller');
        $this->setEntityNamespace('App\\Student');
        $this->setEntityName('Student');
        $this->setTag('@student');
    }
    
    /**
     * @Route("/students", name="student_homepage")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT_SHOW')")
     *
     * @param StudentService $studentService
     *
     * @param Breadcrumbs    $breadcrumbs
     *
     * @return Response
     */
    public function home(StudentService $studentService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($studentService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = [ 'name' => 'Etudiants', 'url' => 'student_homepage' ];
        $this->setBreadcrumbs($breads);
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des étudiants");
        $this->setTableType('table.html.twig');
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
     * @Route("/students/add", name="student_add")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT_ADD')")
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
        $breads[] = ['name' => 'Etudiants', 'url' => 'student_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'student_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('student_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/students/update", name="student_upd")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT_UPD')")
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
        $breads[] = ['name' => 'Etudiants', 'url' => 'student_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'student_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('student_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/students/delete", name="student_del")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT_DEL')")
     *
     * @param OrmService $ormService
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('student_homepage');
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/students/edit", name="student_edit")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT_SHOW')")
     * @param StudentService $studentService
     * @param Breadcrumbs    $breadcrumbs
     *
     * @return Response
     */
    public function detail(StudentService $studentService, Breadcrumbs $breadcrumbs){
        $this->setService($studentService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads = array();
        $breads[] = array('name'=>'Etudiants','url'=>'student_homepage');
        $breads[] = array('name'=>'Fiche','url'=>'student_edit');
        $this->setBreadcrumbs($breads);
        
        return parent::edit();
    }
}