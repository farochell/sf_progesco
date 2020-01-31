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
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ScholarshipPaymentPlan
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class ScholarshipPaymentPlan extends ManagerController
{
    private $snappy;
    private $appKernel;
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [ // on merge le tableau des services par defaut avec notre tableau personnalisé
                                                              'knp_snappy.pdf' => 'Knp\Snappy\Pdf',
                                                              'organization.service' => 'App\Configuration\Service\OrganizationService'
        ]);
    }
    
    public function __construct(KernelInterface $appKernel, OrmService $ormService, ScholarshipPaymentPlanService $scholarshipPaymentPlanService,
        Breadcrumbs $breadcrumbs)
    {
        $this->appKernel = $appKernel;
        $this->setController('ScholarshipPaymentPlan');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setBreadcrumbService($breadcrumbs);
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
    }
    
    /**
     * @return Response
     */
    public function getByPayment()
    {
        return parent::customFunction('getByPayment');
    }
    
    /**
     * @Route("/scholarshippaymentplans/add", name="scholarshippaymentplan_add")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_ADD')")
     *
     * @return Response
     */
    public function add()
    {
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
    public function updateStatus()
    {
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
    public function delete()
    {
        $this->setUrl('scholarshippayment_edit', ['id' => $this->getRequest()->get('scholarshippayment_id')]);
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/scholarshippaymentplans/payment-receipt", name="scholarshippaymentplan_payment_receipt")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_SHOW')")
     */
    public function downloadPaymentReceipt()
    {
        $filename = 'recu-paiement.pdf';
        $organization = $this->get('organization.service')->find();
        $data = $this->getService()->downloadPaymentReceipt();
        $html = $this->renderView(
            $this->getTag().'\\ScholarshipPaymentPlan\\payment-receip.html.twig',
            [
                'data' => $data,
                'organization' => $organization
            ]
        );
        
        return new PdfResponse(
            $this->snappy->getOutputFromHtml($html, [
                'orientation'=>'Landscape',
                'page-size' => 'A6',
                'footer-center'=>utf8_decode($organization->getName(). ' - ' . $organization->getAddress()),
                'footer-font-size' => '8'
                ]),
            $filename
        );
    }
}