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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ScholarshipPayment
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class ScholarshipPayment extends ManagerController
{
    /**
     * Payment constructor.
     */
    public function __construct()
    {
        $this->setController('ScholarshipPayment');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('ScholarshipPayment');
        $this->setTag('@accounting');
    }
    
    /**
     * @Route("/scholarshippayments", name="scholarshippayment_homepage")
     * @param ScholarshipPaymentService $scholarshippaymentService
     * @param Breadcrumbs    $breadcrumbs
     *
     * @return Response
     */
    public function home(ScholarshipPaymentService $scholarshippaymentService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($scholarshippaymentService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = [ 'name' => 'Paiements des étudiants boursiers', 'url' => 'scholarshippayment_homepage' ];
        $this->setBreadcrumbs($breads);
        $this->addAction(['function' => 'getOpenPayments', 'params' => []]);
        $this->addAction(['function' => 'getClosedPayments', 'params' => []]);
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
     * @param OrmService  $ormService
     *
     * @param Breadcrumbs $breadcrumbs
     *
     * @return Response
     */
    public function add(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
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
     * @param ScholarshipPaymentService $scholarshipPaymentService
     * @param Breadcrumbs    $breadcrumbs
     *
     * @return Response
     */
    public function detail(ScholarshipPaymentService $scholarshipPaymentService, Breadcrumbs $breadcrumbs) {
        $this->setService($scholarshipPaymentService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Paiements des étudiants boursiers', 'url' => 'scholarshippayment_homepage'];
        $breads[] = ['name' => 'Fiche', 'url' => 'scholarshippayment_add'];
        $this->setBreadcrumbs($breads);
        
        return parent::edit();
    }
}