<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   12/01/2020
 * @time  :   14:01
 */

namespace App\Accounting\Controller;

use App\Accounting\Service\ScholarshipPaymentPlanService;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Class ScholarshipPaymentPlan
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class ScholarshipPaymentPlan extends ManagerController {
    private $snappy;
    private $appKernel;
    
    public static function getSubscribedServices(): array {
        return array_merge(
            parent::getSubscribedServices(), [ // on merge le tableau des services par defaut avec notre tableau personnalisé
                                               'knp_snappy.pdf'       => 'Knp\Snappy\Pdf',
                                               'organization.service' => 'App\Configuration\Service\OrganizationService',
            ]
        );
    }
    
    public function __construct(
        KernelInterface $appKernel,
        OrmService $ormService,
        ScholarshipPaymentPlanService $scholarshipPaymentPlanService,
        Breadcrumbs $breadcrumbs,
        TranslatorInterface $translator
    ) {
        $this->appKernel = $appKernel;
        $this->setController('ScholarshipPaymentPlan');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setBreadcrumbService($breadcrumbs);
        $this->setTranslator($translator);
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('ScholarshipPaymentPlan');
        $this->setTag('@accounting');
        $this->setService($scholarshipPaymentPlanService);
        $this->setOrmService($ormService);
        $this->snappy = new Pdf();
        $this->snappy->setBinary('C:\wkhtmltopdf\bin\wkhtmltopdf.exe');
        $this->snappy->setOption('no-outline', true);
        $this->snappy->setOption('page-size', 'LETTER');
        $this->snappy->setOption('encoding', 'UTF-8');
        $this->setMenuItem('ScholarshipPaymentPlan');
        $this->setMenuGroup('Accounting');
    }
    
    /**
     * @return Response
     */
    public function getByPayment() {
        return parent::customFunction('getByPayment');
    }
    
    /**
     * @Route("/scholarshippaymentplans/add", name="scholarshippaymentplan_add")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_ADD')")
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Paiements étudiants boursiers', 'url' => 'scholarshippayment_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'scholarshippaymentplan_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('scholarshippayment_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/scholarshippaymentplans/update/status", name="scholarshippaymentplan_update_status")
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
            return $this->redirectToRoute('scholarshippayment_edit', ['id' => $this->getRequest()->get('scholarshippayment_id')]);
        }
        
    }
    
    /**
     * @Route("/scholarshippaymentplans/delete", name="scholarshippaymentplan_del")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_ADD')")
     *
     * @return Response
     */
    public function delete() {
        $this->setUrl('scholarshippayment_edit', ['id' => $this->getRequest()->get('scholarshippayment_id')]);
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/scholarshippaymentplans/payment-receipt", name="scholarshippaymentplan_payment_receipt")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_SHOW')")
     */
    public function downloadPaymentReceipt() {
        $filename     = 'recu-paiement.pdf';
        $organization = $this->get('organization.service')->find();
        $data         = $this->getService()->downloadPaymentReceipt();
        $html         = $this->renderView(
            $this->getTag().'\\ScholarshipPaymentPlan\\payment-receip.html.twig',
            [
                'data'         => $data,
                'organization' => $organization,
            ]
        );
        
        return new PdfResponse(
            $this->snappy->getOutputFromHtml(
                $html, [
                    'orientation'      => 'Landscape',
                    'page-size'        => 'A6',
                    'footer-center'    => utf8_decode($organization->getName().' - '.$organization->getAddress()),
                    'footer-font-size' => '8',
                ]
            ),
            $filename
        );
    }
    
    /**
     * @Route("/scholarshippaymentplans/pending-transactions", name="scholarshippaymentplan_pending_transactions")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_SHOW')")
     * @return Response
     */
    public function pendingOperations() {
        $this->setMenuItem('ScholarshipPaymentPlanPending');
        $breads[] =
            ['name' => 'Etudiants boursiers - Opérations de paiement en attente de validation', 'url' => 'scholarshippaymentplan_pending_transactions'];
        $this->setBreadcrumbs($breads);
        $this->setDisplayTabs(true);
        $this->addAction(['function' => 'pendingScholarshipPaymentPlan', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Plans de paiements en attente')]]);
        $this->addAction(['function' => 'noValidBankTransfert', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Virements bancaires en attente')]]);
        $this->addAction(['function' => 'pendingCheque', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Chèques à encaisser')]]);
        
        return parent::index();
    }
    
    /**
     * @return Response
     */
    public function pendingScholarshipPaymentPlan() {
        $this->setCardTitle("Liste des plans de paiements en attente de validations");
        
        return parent::customFunction('pendingScholarshipPaymentPlan');
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
     * @Route("/scholarshippaymentplans/validated-transactions", name="scholarshippaymentplan_validated_transactions")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_SHOW')")
     * @return Response
     */
    public function validatedOperations() {
        $this->setMenuItem('ScholarshipPaymentPlanValidated');
        $breads[] = ['name' => 'Etudiants boursiers - Opérations de paiement validées', 'url' => 'paymentplan_validated_transactions'];
        $this->setBreadcrumbs($breads);
        $this->setDisplayTabs(true);
        $this->addAction(['function' => 'chequeValidedScholarshipPaymentPlan', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Chèques encaissés')]]);
        $this->addAction(['function' => 'transfertValidedScholarshipPaymentPlan', 'params' => [], 'tab' => ['title' => $this->getTranslator()
                                                                                                                            ->trans('Virements bancaires validés')]]);
        
        return parent::index();
    }
    
    /**
     * @return Response
     */
    public function chequeValidedScholarshipPaymentPlan() {
        $this->setCardTitle("Liste des paiements par chèque validés");
        
        return parent::customFunction('chequeValidedScholarshipPaymentPlan');
    }
    
    /**
     * @return Response
     */
    public function transfertValidedScholarshipPaymentPlan() {
        $this->setCardTitle("Liste des paiements par transfert bancaire validés");
        
        return parent::customFunction('transfertValidedScholarshipPaymentPlan');
    }
}