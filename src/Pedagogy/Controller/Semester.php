<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   27/11/2019
 * @time  :   22:16
 */

namespace App\Pedagogy\Controller;

use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Pedagogy\Service\SemesterService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class Semester
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Semester extends ManagerController
{
    /**
     * SemesterController constructor.
     */
    public function __construct()
    {
        $this->setController('Semester');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Semester');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/semesters", name="semester_homepage")
     *
     * @param SemesterService $semesterService
     *
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function home(SemesterService $semesterService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($semesterService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Périodes', 'url' => 'semester_homepage'];
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des périodes");
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
     * @Route("/semesters/add", name="semester_add")
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
        $breads[] = ['name' => 'Périodes', 'url' => 'semester_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'semester_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('semester_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/semesters/update", name="semester_upd")
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
        $breads[] = ['name' => 'Périodes', 'url' => 'semester_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'semester_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('semester_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/semesters/delete", name="semester_del")
     *
     * @param OrmService $ormService
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('semester_homepage');
        
        return parent::deleteRecord();
    }
}