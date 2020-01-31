<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   15:40
 */

namespace App\Accounting\Controller;

use App\Accounting\Service\PaymentPlanService;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class PaymentPlan
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class PaymentPlan extends ManagerController
{
    /**
     * PaymentPlan constructor.
     *
     * @param OrmService         $ormService
     * @param PaymentPlanService $paymentPlanService
     * @param Breadcrumbs        $breadcrumbs
     */
    public function __construct(OrmService $ormService, PaymentPlanService $paymentPlanService, Breadcrumbs $breadcrumbs)
    {
        $this->setController('PaymentPlan');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setBreadcrumbService($breadcrumbs);
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('PaymentPlan');
        $this->setTag('@accounting');
        $this->setService($paymentPlanService);
        $this->setOrmService($ormService);
    }
    
    /**
     * @Route("/paymentplans/pending-operations", name="paymentplan_pending_operations")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_SHOW')")
     * @return Response
     */
    public function pendingOperations()
    {
        $breads   = [];
        $breads[] = ['name' => 'Opérations de paiement en attente de validation', 'url' => 'paymentplan_pending_operations'];
        $this->setBreadcrumbs($breads);
        $this->addAction(['function' => 'pendingPaymentPlan', 'params' => []]);
        $this->addAction(['function' => 'noValidBankTransfert', 'params' => []]);
        $this->addAction(['function' => 'pendingCheque', 'params' => []]);
        
        return parent::index();
    }
    
    /**
     * @Route("/paymentplans/valided-operations", name="paymentplan_valided_operations")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_SHOW')")
     * @return Response
     */
    public function validedOperations()
    {
        $breads   = [];
        $breads[] = ['name' => 'Opérations de paiement validées', 'url' => 'paymentplan_valided_operations'];
        $this->setBreadcrumbs($breads);
        $this->addAction(['function' => 'cashValidedPaymentPlan', 'params' => []]);
        $this->addAction(['function' => 'chequeValidedPaymentPlan', 'params' => []]);
        $this->addAction(['function' => 'transfertValidedPaymentPlan', 'params' => []]);
    
        return parent::index();
    }
    
    /**
     * @return Response
     */
    public function pendingPaymentPlan()
    {
        $this->setCardTitle("Liste des plans de paiements en attente de validations");
        
        return parent::customFunction('pendingPaymentPlan');
    }
    
    /**
     * @return Response
     */
    public function noValidBankTransfert()
    {
        $this->setCardTitle("Liste des virements en attente de validation");
        
        return parent::customFunction('noValidBankTransfert');
    }
    
    /**
     * @return Response
     */
    public function pendingCheque()
    {
        $this->setCardTitle("Liste des chèques à encaisser");
        
        return parent::customFunction('pendingCheque');
    }
    
    /**
     * @return Response
     */
    public function cashValidedPaymentPlan()
    {
        $this->setCardTitle("Liste des paiements en espèce validés");
    
        return parent::customFunction('cashValidedPaymentPlan');
    }
    
    /**
     * @return Response
     */
    public function chequeValidedPaymentPlan()
    {
        $this->setCardTitle("Liste des paiements par chèque validés");
        
        return parent::customFunction('chequeValidedPaymentPlan');
    }
    
    /**
     * @return Response
     */
    public function transfertValidedPaymentPlan()
    {
        $this->setCardTitle("Liste des paiements par transferts bancaires validés");
        
        return parent::customFunction('transfertValidedPaymentPlan');
    }
    
    /**
     * @Route("/paymentplans/add", name="paymentplan_add")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_ADD')")
     *
     * @return Response
     */
    public function add()
    {
        $breads   = [];
        $breads[] = ['name' => 'Paiements étudiants réguliers', 'url' => 'payment_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'paymentplan_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('payment_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @return Response
     */
    public function getByPayment()
    {
        return parent::customFunction('getByPayment');
    }
    
    /**
     * @Route("/paymentplans/update/status", name="paymentplan_update_status")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_ADD')")
     *
     * @return Response
     */
    public function updateStatus()
    {
        $this->getService()->updateStatus();
        $redirect = $this->getRequest()->get('redirect');
        if (isset($redirect)) {
            return $this->redirectToRoute($redirect, []);
        } else {
            return $this->redirectToRoute('payment_edit', ['id' => $this->getRequest()->get('payment_id')]);
        }
        
    }
    
    /**
     * @Route("/paymentplans/delete", name="paymentplan_del")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_ADD')")
     *
     * @return Response
     */
    public function delete()
    {
        $this->setUrl('payment_edit',  ['id' => $this->getRequest()->get('payment_id')]);
        return parent::deleteRecord();
    }
}