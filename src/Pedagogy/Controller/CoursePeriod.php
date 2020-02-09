<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 16/11/2019
 */

namespace App\Pedagogy\Controller;

use App\Pedagogy\Service\CoursePeriodService;
use App\Manager\Service\OrmService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use App\Manager\Controller\ManagerController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
/**
 * Class CoursePeriodController
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class CoursePeriod extends ManagerController {
    /**
     * CoursePeriodController constructor.
     *
     * @param CoursePeriodService $courseperiodService
     * @param OrmService          $ormService
     * @param TranslatorInterface $translator
     */
    public function __construct(CoursePeriodService $courseperiodService, OrmService $ormService, TranslatorInterface $translator) {
        $this->setService($courseperiodService);
        $this->setOrmService($ormService);
        $this->setTranslator($translator);
        $this->setController('CoursePeriod');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('CoursePeriod');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/courseperiods", name="courseperiod_homepage")
     *
     * @param CoursePeriodService $courseperiodService
     *
     * @return Response
     */
    public function home() {
        
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des types de vacation");
        
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
     * @Route("/courseperiods/add", name="courseperiod_add")
     *
     *
     * @param OrmService $ormService
     *
     * @return Response
     */
    public function add() {
        
        $breads   = [];
        $breads[] = ['name' => 'Types de vacation', 'url' => 'courseperiod_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'courseperiod_add'];
        $this->setUrl('courseperiod_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/courseperiods/update", name="courseperiod_upd")
     *
     *
     * @param OrmService $ormService
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Types de vacation', 'url' => 'courseperiod_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'courseperiod_upd'];
        $this->setUrl('courseperiod_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/courseperiods/delete", name="courseperiod_del")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('courseperiod_homepage');
        
        return parent::deleteRecord();
    }
}