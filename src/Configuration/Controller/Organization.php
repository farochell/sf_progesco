<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   14/01/2020
 * @time  :   11:23
 */

namespace App\Configuration\Controller;

use App\Configuration\Service\OrganizationService;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class Organization
 *
 * @package App\Configuration\Controller
 * @Route("/admin")
 */
class Organization extends ManagerController {
    /**
     * Organization constructor.
     *
     * @param OrmService          $ormService
     * @param OrganizationService $organizationService
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     * @param LoggerInterface     $logger
     */
    public function __construct(
        OrmService $ormService,
        OrganizationService $organizationService,
        Breadcrumbs $breadcrumbs,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($organizationService);
        $this->setController('Organization');
        $this->setBundle('App\\Configuration\\Controller');
        $this->setEntityNamespace('App\\Configuration');
        $this->setEntityName('Organization');
        $this->setTag('@configuration');
    }
    
    /**
     * @Route("/organizations", name="organization_homepage")
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
        $this->setCardTitle("Liste des établissements");
        $breads   = [];
        $breads[] = ['name' => 'Etablissements', 'url' => 'organization_homepage'];
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
     * @Route("/organizations/add", name="organization_add")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Etablissements', 'url' => 'organization_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'organization_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('organization_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/organizations/update", name="organization_upd")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Etablissements', 'url' => 'organization_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'organization_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('organization_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/organizations/delete", name="organization_del")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('organization_homepage');
        
        return parent::deleteRecord();
    }
}