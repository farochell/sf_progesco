<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   26/12/2019
 * @time  :   13:19
 */

namespace App\Accounting\Controller;

use App\Accounting\Service\TuitionService;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class Tuition
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class Tuition extends ManagerController {
    /**
     * Tuition constructor.
     *
     * @param OrmService          $ormService
     * @param TranslatorInterface $translator
     * @param LoggerInterface     $logger
     * @param Breadcrumbs         $breadcrumbs
     * @param TuitionService      $tuitionService
     */
    public function __construct(
        OrmService $ormService,
        TranslatorInterface $translator,
        LoggerInterface $logger,
        Breadcrumbs $breadcrumbs,
        TuitionService $tuitionService
    ) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($tuitionService);
        $this->setController('Tuition');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('Tuition');
        $this->setTag('@accounting');
    }
    
    /**
     * @Route("/tuitions", name="tuition_homepage")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUITION_SHOW')")
     * @return Response
     */
    public function home() {
        $this->getRequest()
             ->getSession()
             ->set(
                 'uri', $this->getRequest()
                             ->getUri()
             );
        
        $breads   = [];
        $breads[] = ['name' => 'Frais de scolarité', 'url' => 'tuition_homepage'];
        $this->setBreadcrumbs($breads);
        
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Frais de scolarité");
        
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
     * @Route("/tuitions/add", name="tuition_add")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUITION_ADD')")
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Frais de scolarité', 'url' => 'tuition_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'tuition_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('tuition_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/tuition/update", name="tuition_upd")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUITION_UPD')")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Frais de scolarité', 'url' => 'tuition_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'tuition_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('tuition_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/tuition/delete", name="tuition_del")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUITION_DEL')")
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('tuition_homepage');
        
        return parent::deleteRecord();
    }
}