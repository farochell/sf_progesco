<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   25/11/2019
 * @time  :   11:19
 */

namespace App\Classroom\Controller;


use App\Classroom\Service\ClassroomService;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class Classroom
 *
 * @package App\Classroom\Controller
 * @Route("/admin")
 */
class Classroom extends ManagerController
{
    /**
     * ClassroomController constructor.
     */
    public function __construct()
    {
        $this->setController('Classroom');
        $this->setBundle('App\\Classroom\\Controller');
        $this->setEntityNamespace('App\\Classroom');
        $this->setEntityName('Classroom');
        $this->setTag('@classroom');
    }
    
    /**
     * @Route("/classroom", name="classroom_homepage")
     *
     * @param ClassroomService $classroomService
     *
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function home(ClassroomService $classroomService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($classroomService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Salles de classe', 'url' => 'speciality_homepage'];
        $this->setBreadcrumbs($breads);
        
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des salles de classe");
        
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
     * @Route("/classroom/add", name="classroom_add")
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
        $breads[] = ['name' => 'Salles de classe', 'url' => 'classroom_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'classroom_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('classroom_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/classroom/update", name="classroom_upd")
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
        $breads[] = ['name' => 'Salles de classe', 'url' => 'classroom_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'classroom_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('classroom_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/classroom/delete", name="classroom_del")
     *
     * @param OrmService $ormService
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('classroom_homepage');
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/classroom/edit", name="classroom_edit")
     * @param ClassroomService $classroomService
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function detail(ClassroomService $classroomService, Breadcrumbs $breadcrumbs){
        $this->setService($classroomService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads = array();
        $breads[] = array('name'=>'Salles de classe','url'=>'classroom_homepage');
        $breads[] = array('name'=>'Fiche','url'=>'classroom_edit');
        $this->setBreadcrumbs($breads);
        
        return parent::edit();
    }
}