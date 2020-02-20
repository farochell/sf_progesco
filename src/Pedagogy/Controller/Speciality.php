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
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class Speciality
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Speciality extends ManagerController {
    /**
     * SpecialityController constructor.
     *
     * @param SpecialityService   $specialityService
     * @param OrmService          $ormService
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     */
    public function __construct(
        SpecialityService $specialityService,
        OrmService $ormService,
        Breadcrumbs $breadcrumbs,
        TranslatorInterface $translator
    ) {
        $this->setService($specialityService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setOrmService($ormService);
        $this->setTranslator($translator);
        $this->setController('Speciality');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Speciality');
        $this->setMenuItem('Speciality');
        $this->setMenuGroup('Pedagogy');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/specialities", name="speciality_homepage")
     *
     * @param SpecialityService $specialityService
     *
     * @param Breadcrumbs       $breadcrumbs
     *
     * @return Response
     */
    public function home() {
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
     * @Route("/specialities/add", name="speciality_add")
     *
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Spécialités', 'url' => 'speciality_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'speciality_add'];
        $this->setUrl('speciality_homepage');
        $this->setBreadcrumbs($breads);
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/specialities/update", name="speciality_upd")
     *
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Spécialités', 'url' => 'speciality_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'speciality_upd'];
        $this->setUrl('speciality_homepage');
        $this->setBreadcrumbs($breads);
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/specialities/delete", name="speciality_del")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('speciality_homepage');
        
        return parent::deleteRecord();
    }
}