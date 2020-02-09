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
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Class Cheque
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class Cheque extends ManagerController {
    
    /**
     * Cheque constructor.
     *
     * @param OrmService          $ormService
     * @param TranslatorInterface $translator
     * @param LoggerInterface     $logger
     * @param Breadcrumbs         $breadcrumbs
     * @param ChequeService       $chequeService
     */
    public function __construct(
        OrmService $ormService,
        TranslatorInterface $translator,
        LoggerInterface $logger,
        Breadcrumbs $breadcrumbs,
        ChequeService $chequeService
    ) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($chequeService);
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
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Paiements étudiants réguliers', 'url' => 'payment_homepage'];
        $breads[] = ['name' => 'Chèque - Formulaire ajout', 'url' => 'payment_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('payment_homepage');
        
        return parent::addRecord();
    }
}