<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 16/11/2019
 */

namespace App\Configuration\Controller;

use App\Configuration\Service\GenderService;
use App\Manager\Service\OrmService;
use Psr\Log\LoggerInterface;
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
 * Class GenderController
 *
 * @package App\Configuration\Controller
 * @Route("/admin")
 */
class Gender extends ManagerController {
    /**
     * GenderController constructor.
     *
     * @param OrmService          $ormService
     * @param GenderService       $genderService
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     * @param LoggerInterface     $logger
     */
    public function __construct(OrmService $ormService, GenderService $genderService, Breadcrumbs $breadcrumbs, TranslatorInterface $translator, LoggerInterface $logger) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($genderService);
        $this->setController('Gender');
        $this->setBundle('App\\Configuration\\Controller');
        $this->setEntityNamespace('App\\Configuration');
        $this->setEntityName('Gender');
        $this->setMenuItem('Gender');
        $this->setMenuGroup('Configuration');
        $this->setTag('@configuration');
    }
    
    /**
     * @Route("/genders", name="gender_homepage")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CONFIGURATION_SHOW')")
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
        $this->setCardTitle("Liste des genres");
        $breads   = [];
        $breads[] = ['name' => 'Genres', 'url' => 'gender_homepage'];
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
     * @Route("/genders/add", name="gender_add")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CONFIGURATION_ADD')")
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Genres', 'url' => 'gender_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'gender_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('gender_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/genders/update", name="gender_upd")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CONFIGURATION_UPD') ")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Genres', 'url' => 'gender_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'gender_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('gender_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/genders/delete", name="gender_del")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CONFIGURATION_DEL')")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('gender_homepage');
        
        return parent::deleteRecord();
    }
}