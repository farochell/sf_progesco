<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   19:04
 */

namespace App\Accounting\Controller;


use App\Accounting\Service\ChequeService;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Class Cheque
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class Cheque extends ManagerController
{
    /**
     * Cheque constructor.
     *
     * @param OrmService    $ormService
     * @param ChequeService $chequeService
     * @param Breadcrumbs   $breadcrumbs
     */
    public function __construct(OrmService $ormService, ChequeService $chequeService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($chequeService);
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setController('Cheque');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('Cheque');
        $this->setTag('@accounting');
    }
    
    /**
     * @Route("/cheques/add", name="cheque_add")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAYMENT_ADD')")
     *
     * @return Response
     */
    public function add()
    {
        $breads   = [];
        $breads[] = ['name' => 'Paiements étudiants réguliers', 'url' => 'payment_homepage'];
        $breads[] = ['name' => 'Chèque - Formulaire ajout', 'url' => 'payment_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('payment_homepage');
        
        return parent::addRecord();
    }
}