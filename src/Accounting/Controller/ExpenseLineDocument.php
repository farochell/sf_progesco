<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   15/02/2020
 */

namespace App\Accounting\Controller;


use App\Accounting\Service\ExpenseLineDocumentService;
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
 * Class ExpenseLineDocument
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class ExpenseLineDocument extends ManagerController {
    
    /**
     * ExpenseLine constructor.
     *
     * @param OrmService                 $ormService
     * @param TranslatorInterface        $translator
     * @param LoggerInterface            $logger
     * @param Breadcrumbs                $breadcrumbs
     * @param ExpenseLineDocumentService $expenseLineDocumentService
     */
    public function __construct(
        OrmService $ormService,
        TranslatorInterface $translator,
        LoggerInterface $logger,
        Breadcrumbs $breadcrumbs,
        ExpenseLineDocumentService $expenseLineDocumentService
    ) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($expenseLineDocumentService);
        $this->setController('ExpenseLineDocument');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('ExpenseLineDocument');
        $this->setTag('@accounting');
    }
    
    /**
     * @Route("/expenselinedocuments/add", name="expense_line_document_add")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function add() {
        $this->setUseDefault(false);
        $breads   = [];
        $breads[] = ['name' => 'Liste des dépenses', 'url' => 'expenseline_homepage'];
        $breads[] = ['name' => 'Fiche', 'url' => 'expenseline_detail', 'params' => ['id' => $this->getRequest()->get('expense_line_id')]];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'expense_line_document_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('expenseline_detail', ['id' => $this->getRequest()->get('expense_line_id')]);
    
        return parent::addRecord();
    }
    
    /**
     * @param $params
     *
     * @return mixed
     */
    public function findDocumentsByExpense($params) {
        $this->setCardTitle('Liste des justicatifs');
        return parent::customFunction("findDocumentsByExpense", $params);
    }
}