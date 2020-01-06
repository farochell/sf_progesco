<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   26/12/2019
 * @time  :   13:19
 */

namespace App\Accounting\Controller;

use App\Accounting\Service\TuitionService;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Class Tuition
 *
 * @package App\Accounting\Controller
 * @Route("/admin")
 */
class Tuition extends ManagerController
{
    /**
     * Tuition constructor.
     */
    public function __construct()
    {
        $this->setController('Tuition');
        $this->setBundle('App\\Accounting\\Controller');
        $this->setEntityNamespace('App\\Accounting');
        $this->setEntityName('Tuition');
        $this->setTag('@accounting');
    }
    
    /**
     * @Route("/tuitions", name="tuition_homepage")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUITION_SHOW')")
     * @param TuitionService $tuitionService
     *
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function home(TuitionService $tuitionService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($tuitionService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Frais de scolarité', 'url' => 'tuition_homepage'];
        $this->setBreadcrumbs($breads);
        
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Frais de scolarité");
        
        return parent::index();
    }
    
    /**
     * @param $params
     *
     * @return Response
     */
    public function show($params)
    {
        return parent::customFunction("findAll", $params);
    }
    
    /**
     * @Route("/tuitions/add", name="tuition_add")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUITION_ADD')")
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
        $breads[] = ['name' => 'Frais de scolarité', 'url' => 'tuition_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'tuition_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('tuition_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/tuition/update", name="tuition_upd")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUITION_UPD')")
     *
     * @param OrmService  $ormService
     *
     * @param Breadcrumbs $breadcrumbs
     *
     * @return Response
     */
    public function update(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Frais de scolarité', 'url' => 'tuition_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'tuition_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('tuition_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/tuition/delete", name="tuition_del")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUITION_DEL')")
     * @param OrmService $ormService
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('tuition_homepage');
        
        return parent::deleteRecord();
    }
}