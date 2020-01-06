<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 16/11/2019
 */

namespace App\Configuration\Controller;
use App\Configuration\Service\GenderService;
use App\Manager\Service\OrmService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Manager\Controller\ManagerController;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * Class GenderController
 *
 * @package App\Configuration\Controller
 * @Route("/admin")
 */
class Gender extends ManagerController
{
    /**
     * GenderController constructor.
     */
    public function __construct() {
        $this->setController('Gender');
        $this->setBundle('App\\Configuration\\Controller');
        $this->setEntityNamespace('App\\Configuration');
        $this->setEntityName('Gender');
        $this->setTag('@configuration');
    }
    
    /**
     * @Route("/genders", name="gender_homepage")
     * @Security("is_granted('ROLE_ADMIN')")
     * @param GenderService $genderService
     * @param Breadcrumbs   $breadcrumbs
     *
     * @return Response
     */
    public function home(GenderService $genderService, Breadcrumbs $breadcrumbs){
        $this->setService($genderService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des genres");
        $breads   = [];
        $breads[] = [ 'name' => 'Genres', 'url' => 'gender_homepage' ];
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
     * @Route("/genders/add", name="gender_add")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @param OrmService  $ormService
     * @param Breadcrumbs $breadcrumbs
     *
     * @return Response
     */
    public function add(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = [ 'name' => 'Genres', 'url' => 'gender_homepage' ];
        $breads[] = [ 'name' => 'Formulaire ajout', 'url' => 'gender_add' ];
        $this->setBreadcrumbs($breads);
        $this->setUrl('gender_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/genders/update", name="gender_upd")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @param OrmService  $ormService
     * @param Breadcrumbs $breadcrumbs
     *
     * @return Response
     */
    public function update(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = [ 'name' => 'Genres', 'url' => 'gender_homepage' ];
        $breads[] = [ 'name' => 'Formulaire modification', 'url' => 'gender_upd' ];
        $this->setBreadcrumbs($breads);
        $this->setUrl('gender_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/genders/delete", name="gender_del")
     * @Security("is_granted('ROLE_ADMIN')")
     * @param OrmService $ormService
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('gender_homepage');
        return parent::deleteRecord();
    }
}