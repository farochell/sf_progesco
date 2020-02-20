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
use Symfony\Contracts\Translation\TranslatorInterface;
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
class SchoolYear extends ManagerController {
    /**
     * SchoolYearController constructor.
     *
     * @param OrmService          $ormService
     * @param SchoolYearService   $schoolyearService
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     */
    public function __construct(
        OrmService $ormService,
        SchoolYearService $schoolyearService,
        Breadcrumbs $breadcrumbs,
        TranslatorInterface $translator
    ) {
        $this->setOrmService($ormService);
        $this->setService($schoolyearService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setTranslator($translator);
        $this->setController('SchoolYear');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('SchoolYear');
        $this->setMenuItem('SchoolYear');
        $this->setMenuGroup('Pedagogy');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/schoolyears", name="schoolyear_homepage")
     *
     * @return Response
     */
    public function home() {
        
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
    public function show($params) {
        return parent::customFunction("findAll", $params);
    }
    
    /**
     * @Route("/schoolyears/add", name="schoolyear_add")
     *
     *
     * @return Response
     */
    public function add() {
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
     * @return Response
     */
    public function update() {
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
    public function delete() {
        $this->setUrl('schoolyear_homepage');
        
        return parent::deleteRecord();
    }
}