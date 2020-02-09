<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   02/01/2020
 * @time  :   17:41
 */

namespace App\Accounting\Controller;

use App\Accounting\Service\ScholarshipPaymentService;
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
 * Class ScholarshipPayment
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class ScholarshipPayment extends ManagerController {
    /**
     * ScholarshipPayment constructor.
     *
     * @param OrmService                $ormService
     * @param TranslatorInterface       $translator
     * @param LoggerInterface           $logger
     * @param Breadcrumbs               $breadcrumbs
     * @param ScholarshipPaymentService $scholarshippaymentService
     */
    public function __construct(
        OrmService $ormService,
        TranslatorInterface $translator,
        LoggerInterface $logger,
        Breadcrumbs $breadcrumbs,
        ScholarshipPaymentService $scholarshippaymentService
    ) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($scholarshippaymentService);
        $this->setController('ScholarshipPayment');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('ScholarshipPayment');
        $this->setTag('@accounting');
    }
    
    /**
     * @Route("/scholarshippayments", name="scholarshippayment_homepage")
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
        $breads[] = ['name' => 'Paiements des étudiants boursiers', 'url' => 'scholarshippayment_homepage'];
        $this->setBreadcrumbs($breads);
        $this->setDisplayTabs(true);
        $this->addAction(['function' => 'getOpenPayments', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Paiements soldés')]]);
        $this->addAction(['function' => 'getClosedPayments', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Paiements soldés')]]);
        
        return parent::index();
    }
    
    /**
     * @return Response
     */
    public function getOpenPayments() {
        $this->setCardTitle("Liste des paiements des étudiants boursiers non soldés");
        
        return parent::customFunction("getOpenPayments");
    }
    
    /**
     * @return Response
     */
    public function getClosedPayments() {
        $this->setCardTitle("Liste des paiements des étudiants boursiers soldés");
        
        return parent::customFunction("getClosedPayments");
    }
    
    /**
     * @Route("/scholarshippayments/add", name="scholarshippayment_add")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_ADD')")
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Paiements des étudiants boursiers', 'url' => 'scholarshippayment_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'scholarshippayment_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('tuition_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/scholarshippayments/edit", name="scholarshippayment_edit")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_SHOW')")
     * @return Response
     */
    public function detail() {
        $breads   = [];
        $breads[] = ['name' => 'Paiements des étudiants boursiers', 'url' => 'scholarshippayment_homepage'];
        $breads[] = ['name' => 'Fiche', 'url' => 'scholarshippayment_add'];
        $this->setBreadcrumbs($breads);
        
        return parent::edit();
    }
    
}