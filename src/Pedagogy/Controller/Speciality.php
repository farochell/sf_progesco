<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   22/11/2019
 * @time  :   15:01
 */

namespace App\Pedagogy\Controller;


use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Pedagogy\Service\SpecialityService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class Speciality
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Speciality extends ManagerController
{
    /**
     * SpecialityController constructor.
     */
    public function __construct() {
        $this->setController('Speciality');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Speciality');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/speciality", name="speciality_homepage")
     *
     * @param SpecialityService $specialityService
     *
     * @param Breadcrumbs       $breadcrumbs
     *
     * @return Response
     */
    public function home(SpecialityService $specialityService, Breadcrumbs $breadcrumbs){
        $this->setService($specialityService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Spécialités', 'url' => 'speciality_homepage'];
        $this->setBreadcrumbs($breads);
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des Spécialités");
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
     * @Route("/speciality/add", name="speciality_add")
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
        $breads[] = [ 'name' => 'Spécialités', 'url' => 'speciality_homepage' ];
        $breads[] = [ 'name' => 'Formulaire ajout', 'url' => 'speciality_add' ];
        $this->setUrl('speciality_homepage');
        $this->setBreadcrumbs($breads);
        return parent::addRecord();
    }
    
    /**
     * @Route("/speciality/update", name="speciality_upd")
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
        $breads[] = [ 'name' => 'Spécialités', 'url' => 'speciality_homepage' ];
        $breads[] = [ 'name' => 'Formulaire modification', 'url' => 'speciality_upd' ];
        $this->setUrl('speciality_homepage');
        $this->setBreadcrumbs($breads);
        return parent::updateRecord();
    }
    
    /**
     * @Route("/speciality/delete", name="speciality_del")
     *
     * @param OrmService $ormService
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('speciality_homepage');
        return parent::deleteRecord();
    }
}