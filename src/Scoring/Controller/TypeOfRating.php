<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/02/2020
 * @time  :   11:26
 */

namespace App\Scoring\Controller;


use App\Manager\Service\OrmService;
use App\Scoring\Service\TypeOfRatingService;
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
 * Class TypeOfRating
 *
 * @package App\Scoring\Controller
 * @Route("/admin")
 */
class TypeOfRating extends ManagerController {
    
    /**
     * GenderController constructor.
     *
     * @param OrmService          $ormService
     * @param TypeOfRatingService $typeOfRatingService
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     */
    public function __construct(OrmService $ormService, TypeOfRatingService $typeOfRatingService, Breadcrumbs $breadcrumbs, TranslatorInterface $translator) {
        $this->setOrmService($ormService);
        $this->setService($typeOfRatingService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setTranslator($translator);
        $this->setController('TypeOfRating');
        $this->setBundle('App\\Scoring\\Controller');
        $this->setEntityNamespace('App\\Scoring');
        $this->setEntityName('TypeOfRating');
        $this->setTag('@scoring');
    }
    
    /**
     * @Route("/typeofratings", name="typeofrating_homepage")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function home() {
        $this->getRequest()
             ->getSession()
             ->set(
                 'uri', $this->getRequest()
                             ->getUri()
             );
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des types de devoir");
        $breads   = [];
        $breads[] = ['name' => 'Types de devoir', 'url' => 'typeofrating_homepage'];
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
     * @Route("/typeofratings/add", name="typeofrating_add")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Types de devoir', 'url' => 'typeofrating_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'typeofrating_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('typeofrating_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/typeofratings/update", name="typeofrating_upd")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Types de devoir', 'url' => 'typeofrating_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'typeofrating_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('typeofrating_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/typeofratings/delete", name="typeofrating_del")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('typeofrating_homepage');
        
        return parent::deleteRecord();
    }
}