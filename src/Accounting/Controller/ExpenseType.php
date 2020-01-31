<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   15/01/2020
 * @time  :   14:08
 */

namespace App\Accounting\Controller;


use App\Accounting\Service\ExpenseTypeService;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ExpenseType
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class ExpenseType extends ManagerController
{
    /**
     * ExpenseType constructor.
     *
     * @param OrmService         $ormService
     * @param ExpenseTypeService $expensetypeService
     * @param Breadcrumbs        $breadcrumbs
     */
    public function __construct(OrmService $ormService, ExpenseTypeService $expensetypeService, Breadcrumbs $breadcrumbs) {
        $this->setOrmService($ormService);
        $this->setService($expensetypeService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setController('ExpenseType');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('ExpenseType');
        $this->setTag('@accounting');
    }
    
    /**
     * @Route("/expensetypes", name="expensetype_homepage")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function home(){
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des types de dépense");
        $breads   = [];
        $breads[] = [ 'name' => 'Types de dépense', 'url' => 'expensetype_homepage' ];
        $this->setBreadcrumbs($breads);
        
        return parent::index();
    }
    
    /**
     * @param $params
     *
     * @return Response
     */
    public function show($params) {
        return parent::customFunction("findAll", $params);
    }
    
    /**
     * @Route("/expensetypes/add", name="expensetype_add")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function add()
    {
        $breads   = [];
        $breads[] = [ 'name' => 'Types de dépense', 'url' => 'expensetype_homepage' ];
        $breads[] = [ 'name' => 'Formulaire ajout', 'url' => 'expensetype_add' ];
        $this->setBreadcrumbs($breads);
        $this->setUrl('expensetype_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/expensetypes/update", name="expensetype_upd")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function update()
    {
        $breads   = [];
        $breads[] = [ 'name' => 'Types de dépense', 'url' => 'expensetype_homepage' ];
        $breads[] = [ 'name' => 'Formulaire modification', 'url' => 'expensetype_upd' ];
        $this->setBreadcrumbs($breads);
        $this->setUrl('expensetype_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/expensetypes/delete", name="expensetype_del")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete()
    {
        $this->setUrl('expensetype_homepage');
        return parent::deleteRecord();
    }
}