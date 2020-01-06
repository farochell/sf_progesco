<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 16/11/2019
 */

namespace App\Pedagogy\Controller;

use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Pedagogy\Service\SchoolYearService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class SchoolYearController
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class SchoolYear extends ManagerController
{
    /**
     * SchoolYearController constructor.
     */
    public function __construct()
    {
        $this->setController('SchoolYear');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('SchoolYear');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/schoolyears", name="schoolyear_homepage")
     *
     * @param SchoolYearService $schoolyearService
     * @param Breadcrumbs       $breadcrumbs
     *
     * @return Response
     */
    public function home(SchoolYearService $schoolyearService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($schoolyearService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des années scolaires");
        $breads   = [];
        $breads[] = ['name' => 'Années scolaires', 'url' => 'schoolyear_homepage'];
        $this->setBreadcrumbs($breads);
        
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
     * @Route("/schoolyears/add", name="schoolyear_add")
     *
     *
     * @return Response
     */
    public function add(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Années scolaires', 'url' => 'schoolyear_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'schoolyear_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('schoolyear_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/schoolyears/update", name="schoolyear_upd")
     *
     *
     * @param OrmService  $ormService
     * @param Breadcrumbs $breadcrumbs
     *
     * @return Response
     */
    public function update(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Années scolaires', 'url' => 'schoolyear_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'schoolyear_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('schoolyear_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/schoolyears/delete", name="schoolyear_del")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('schoolyear_homepage');
        
        return parent::deleteRecord();
    }
}