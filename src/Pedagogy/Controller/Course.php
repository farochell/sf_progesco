<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   28/11/2019
 * @time  :   15:42
 */

namespace App\Pedagogy\Controller;


use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Pedagogy\Service\CourseService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * Class Course
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Course extends ManagerController
{
    /**
     * CourseController constructor.
     */
    public function __construct() {
        $this->setController('Course');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Course');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/course", name="course_homepage")
     *
     * @param CourseService $courseService
     *
     * @return Response
     */
    public function home(CourseService $courseService){
        $this->setService($courseService);
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des cours planifiés");
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
     * @Route("/course/add", name="course_add")
     *
     *
     * @param OrmService $ormService
     *
     * @return Response
     */
    public function add(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $breads   = [];
        $breads[] = [ 'name' => 'Cours planifiés', 'url' => 'course_homepage' ];
        $breads[] = [ 'name' => 'Formulaire ajout', 'url' => 'course_add' ];
        $this->setUrl('course_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/course/update", name="course_upd")
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
        $breads[] = [ 'name' => 'Cours planifiés', 'url' => 'course_homepage' ];
        $breads[] = [ 'name' => 'Formulaire modification', 'url' => 'course_upd' ];
        $this->setBreadcrumbs($breads);
        $this->setUrl('course_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/course/delete", name="course_del")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('course_homepage');
        return parent::deleteRecord();
    }
}