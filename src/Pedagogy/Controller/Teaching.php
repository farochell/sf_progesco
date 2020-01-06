<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   22/11/2019
 * @time  :   17:16
 */

namespace App\Pedagogy\Controller;


use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Pedagogy\Service\TeachingService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * Class Teaching
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Teaching extends ManagerController
{
    /**
     * TeachingController constructor.
     */
    public function __construct() {
        $this->setController('Teaching');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Teaching');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/teachings", name="teaching_homepage")
     *
     * @param TeachingService $teachingService
     *
     * @return Response
     */
    public function home(TeachingService $teachingService, Breadcrumbs $breadcrumbs){
        $this->setService($teachingService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Matières', 'url' => 'speciality_homepage'];
        $this->setBreadcrumbs($breads);
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des matières");
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
     * @Route("/teachings/add", name="teaching_add")
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
        $breads[] = [ 'name' => 'Matières', 'url' => 'teaching_homepage' ];
        $breads[] = [ 'name' => 'Formulaire ajout', 'url' => 'teaching_add' ];
        $this->setBreadcrumbs($breads);
        $this->setUrl('teaching_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/teachings/update", name="teaching_upd")
     *
     *
     * @param OrmService $ormService
     *
     * @return Response
     */
    public function update(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = [ 'name' => 'Filières', 'url' => 'teaching_homepage' ];
        $breads[] = [ 'name' => 'Formulaire modification', 'url' => 'teaching_upd' ];
        $this->setBreadcrumbs($breads);
        $this->setUrl('teaching_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/teachings/delete", name="teaching_del")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('teaching_homepage');
        return parent::deleteRecord();
    }
}