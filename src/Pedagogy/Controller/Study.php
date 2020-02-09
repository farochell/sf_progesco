<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 16/11/2019
 */

namespace App\Pedagogy\Controller;

use App\Pedagogy\Service\StudyService;
use App\Manager\Service\OrmService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use App\Manager\Controller\ManagerController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * Class StudyController
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Study extends ManagerController {
    /**
     * StudyController constructor.
     *
     * @param StudyService        $studyService
     * @param OrmService          $ormService
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     */
    public function __construct(StudyService $studyService, OrmService $ormService, Breadcrumbs $breadcrumbs, TranslatorInterface $translator) {
        $this->setService($studyService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setOrmService($ormService);
        $this->setTranslator($translator);
        $this->setController('Study');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Study');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/studies", name="study_homepage")
     *
     * @param StudyService $studyService
     *
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function home() {
        $breads   = [];
        $breads[] = ['name' => 'Filières', 'url' => 'speciality_homepage'];
        $this->setBreadcrumbs($breads);
        
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des filières");
        
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
     * @Route("/studies/add", name="study_add")
     *
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Filières', 'url' => 'study_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'study_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('study_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/studies/update", name="study_upd")
     *
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Filières', 'url' => 'study_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'study_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('study_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/studies/delete", name="study_del")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        
        $this->setUrl('study_homepage');
        
        return parent::deleteRecord();
    }
}