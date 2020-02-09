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
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class PaymentPlan
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class PaymentPlan extends ManagerController {
    /**
     * PaymentPlan constructor.
     *
     * @param OrmService         $ormService
     * @param PaymentPlanService $paymentPlanService
     * @param Breadcrumbs        $breadcrumbs
     */
    public function __construct(
        OrmService $ormService,
        TranslatorInterface $translator,
        LoggerInterface $logger,
        Breadcrumbs $breadcrumbs,
        PaymentPlanService $paymentPlanService
    ) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($paymentPlanService);
        $this->setController('PaymentPlan');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('PaymentPlan');
        $this->setTag('@accounting');
    }
    
    /**
     * @Route("/paymentplans/pending-transactions", name="paymentplan_pending_transactions")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_SHOW')")
     * @return Response
     */
    public function pendingTransactions() {
        $breads   = [];
        $breads[] = ['name' => 'Etudiants réguliers - Opérations de paiement en attente de validation', 'url' => 'paymentplan_pending_transactions'];
        $this->setBreadcrumbs($breads);
        $this->setDisplayTabs(true);
        $this->addAction(['function' => 'pendingPaymentPlan', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Plans de paiements en attente de validations')]]);
        $this->addAction(['function' => 'noValidBankTransfert', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Virements en attente de validation')]]);
        $this->addAction(['function' => 'pendingCheque', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Chèques à encaisser')]]);
        
        return parent::index();
    }
    
    /**
     * @Route("/paymentplans/validated-transactions", name="paymentplan_validated_transactions")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_SHOW')")
     * @return Response
     */
    public function validatedTransactions() {
        $breads   = [];
        $breads[] = ['name' => 'Etudiants réguliers - Opérations de paiement validées', 'url' => 'paymentplan_validated_transactions'];
        $this->setBreadcrumbs($breads);
        $this->setDisplayTabs(true);
        $this->addAction(['function' => 'cashValidedPaymentPlan', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Paiements en espèce validés')]]);
        $this->addAction(['function' => 'chequeValidedPaymentPlan', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Paiements par chèque validés')]]);
        $this->addAction(['function' => 'transfertValidedPaymentPlan', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Paiements par transfert bancaire validés')]]);
        
        return parent::index();
    }
    
    /**
     * @return Response
     */
    public function pendingPaymentPlan() {
        $this->setCardTitle("Liste des plans de paiements en attente de validations");
        
        return parent::customFunction('pendingPaymentPlan');
    }
    
    /**
     * @return Response
     */
    public function noValidBankTransfert() {
        $this->setCardTitle("Liste des virements en attente de validation");
        
        return parent::customFunction('noValidBankTransfert');
    }
    
    /**
     * @return Response
     */
    public function pendingCheque() {
        $this->setCardTitle("Liste des chèques à encaisser");
        
        return parent::customFunction('pendingCheque');
    }
    
    /**
     * @return Response
     */
    public function cashValidedPaymentPlan() {
        $this->setCardTitle("Liste des paiements en espèce validés");
        
        return parent::customFunction('cashValidedPaymentPlan');
    }
    
    /**
     * @return Response
     */
    public function chequeValidedPaymentPlan() {
        $this->setCardTitle("Liste des paiements par chèque validés");
        
        return parent::customFunction('chequeValidedPaymentPlan');
    }
    
    /**
     * @return Response
     */
    public function transfertValidedPaymentPlan() {
        $this->setCardTitle("Liste des paiements par transfert bancaire validés");
        
        return parent::customFunction('transfertValidedPaymentPlan');
    }
    
    /**
     * @Route("/paymentplans/add", name="paymentplan_add")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_ADD')")
     *
     * @return Response
     */
    public function add() {
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
    public function getByPayment() {
        return parent::customFunction('getByPayment');
    }
    
    /**
     * @Route("/paymentplans/update/status", name="paymentplan_update_status")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_ADD')")
     *
     * @return Response
     */
    public function updateStatus() {
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
    public function delete() {
        $this->setUrl('payment_edit', ['id' => $this->getRequest()->get('payment_id')]);
        
        return parent::deleteRecord();
    }
}