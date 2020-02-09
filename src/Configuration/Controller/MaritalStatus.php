<?php
/**
 * sf_progesco
 *
 * emile.camara
 * 18/11/2019
 */

namespace App\Configuration\Controller;

use App\Configuration\Service\GenderService;
use App\Configuration\Service\MaritalStatusService;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * Class MaritalStatus
 *
 * @package App\Configuration\Controller
 * @Route("/admin")
 */
class MaritalStatus extends ManagerController {
    /**
     * GenderController constructor.
     *
     * @param MaritalStatusService $maritalStatusService
     * @param OrmService           $ormService
     * @param TranslatorInterface  $translator
     * @param Breadcrumbs          $breadcrumbs
     * @param LoggerInterface      $logger
     */
    public function __construct(
        MaritalStatusService $maritalStatusService,
        OrmService $ormService,
        TranslatorInterface $translator,
        Breadcrumbs $breadcrumbs,
        LoggerInterface $logger
    ) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($maritalStatusService);
        
        $this->setController('MaritalStatus');
        $this->setBundle('App\\Configuration\\Controller');
        $this->setEntityNamespace('App\\Configuration');
        $this->setEntityName('MaritalStatus');
        $this->setTag('@configuration');
    }
    
    /**
     * @Route("/marital-status", name="marital-status_homepage")
     * @Security("is_granted('ROLE_ADMIN')")
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
        $this->setCardTitle("Liste des situations matrimoniales");
    
        $breads   = [];
        $breads[] = ['name' => 'Situations matrimoniales', 'url' => 'marital-status_homepage'];
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
     * @Route("/marital-status/add", name="marital-status_add")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function add() {
        
        $breads   = [];
        $breads[] = ['name' => 'Situations matrimoniales', 'url' => 'marital-status_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'marital-status_add'];
        $this->setUrl('marital-status_homepage');
        $this->setBreadcrumbs($breads);
        return parent::addRecord();
    }
    
    /**
     * @Route("/marital-status/update", name="marital-status_upd")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Genres', 'url' => 'marital-status_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'marital-status_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('marital-status_homepage');
        
        return parent::updateRecord();
    }
}