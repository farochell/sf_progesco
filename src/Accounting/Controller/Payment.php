<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   02/01/2020
 * @time  :   15:16
 */

namespace App\Accounting\Controller;


use App\Accounting\Service\PaymentService;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class Payment
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class Payment extends ManagerController
{
    /**
     * Payment constructor.
     *
     * @param OrmService     $ormService
     * @param PaymentService $paymentService
     * @param Breadcrumbs    $breadcrumbs
     */
    public function __construct(OrmService $ormService, PaymentService $paymentService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($paymentService);
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setController('Payment');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('Payment');
        $this->setTag('@accounting');
    }
    
    /**
     * @Route("/payments", name="payment_homepage")
     *
     * @return Response
     */
    public function home()
    {
        $breads   = [];
        $breads[] = [ 'name' => 'Paiements étudiants réguliers', 'url' => 'payment_homepage' ];
        $this->setBreadcrumbs($breads);
        $this->addAction(['function' => 'getOpenPayments', 'params' => []]);
        $this->addAction(['function' => 'getClosedPayments', 'params' => []]);
        
        return parent::index();
    }
   
    /**
     * @return Response
     */
    public function getOpenPayments() {
        $this->setCardTitle("Liste des paiements des étudiants réguliers non soldés");
        return parent::customFunction("getOpenPayments");
    }
    
    /**
     * @return Response
     */
    public function getClosedPayments() {
        $this->setCardTitle("Liste des paiements des étudiants réguliers soldés");
        return parent::customFunction("getClosedPayments");
    }
    
    /**
     * @Route("/payements/add", name="payment_add")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_ADD')")
     *
     * @return Response
     */
    public function add()
    {
        $breads   = [];
        $breads[] = ['name' => 'Paiements étudiants réguliers', 'url' => 'payment_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'payment_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('payment_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/paiements/edit", name="payment_edit")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_SHOW')")
     *
     * @return Response
     */
    public function detail() {
        $breads   = [];
        $breads[] = ['name' => 'Paiements étudiants réguliers', 'url' => 'payment_homepage'];
        $breads[] = ['name' => 'Fiche', 'url' => 'payment_edit'];
        $this->setBreadcrumbs($breads);
        
        return parent::edit();
    }
}