<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   15/01/2020
 * @time  :   14:34
 */

namespace App\Accounting\Controller;

use App\Accounting\Service\ExpenseLineService;
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
 * Class ExpenseLine
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class ExpenseLine extends ManagerController {
    
    /**
     * ExpenseLine constructor.
     *
     * @param OrmService          $ormService
     * @param TranslatorInterface $translator
     * @param LoggerInterface     $logger
     * @param Breadcrumbs         $breadcrumbs
     * @param ExpenseLineService  $expenselineService
     */
    public function __construct(
        OrmService $ormService,
        TranslatorInterface $translator,
        LoggerInterface $logger,
        Breadcrumbs $breadcrumbs,
        ExpenseLineService $expenselineService
    ) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($expenselineService);
        $this->setController('ExpenseLine');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('ExpenseLine');
        $this->setTag('@accounting');
    }
    
    /**
     * @Route("/expenselines", name="expenseline_homepage")
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
        $this->setCardTitle("Liste des dépenses");
        $breads   = [];
        $breads[] = ['name' => 'Dépenses', 'url' => 'expenseline_homepage'];
        $this->setBreadcrumbs($breads);
        $this->getRequest()
             ->getSession()
             ->set(
                 'uri', $this->getRequest()
                             ->getUri()
             );
        
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
     * @Route("/expenselines/add", name="expenseline_add")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Dépenses', 'url' => 'expenseline_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'expenseline_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('expenseline_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/expenselines/update", name="expenseline_upd")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Dépenses', 'url' => 'expenseline_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'expenseline_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('expenseline_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/expenselines/delete", name="expenseline_del")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('expenseline_homepage');
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/expenselines/edit", name="expenseline_detail")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_SHOW')")
     *
     * @return Response
     */
    public function detail() {
        $breads   = [];
        $breads[] = ['name' => 'Dépenses', 'url' => 'expenseline_homepage'];
        $breads[] = ['name' => 'Fiche', 'url' => 'expenseline_detail'];
        $this->setBreadcrumbs($breads);
        
        return parent::edit();
    }
}