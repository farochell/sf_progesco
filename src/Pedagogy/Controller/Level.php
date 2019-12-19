<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 16/11/2019
 */

namespace App\Pedagogy\Controller;

use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Pedagogy\Service\LevelService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class LevelController
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Level extends ManagerController
{
    /**
     * GenderController constructor.
     */
    public function __construct()
    {
        $this->setController('Level');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Level');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/level", name="level_homepage")
     *
     * @param LevelService $levelService
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function home(LevelService $levelService, Breadcrumbs $breadcrumbs)
    {
        $this->setBreadcrumbService($breadcrumbs);
        $this->setService($levelService);
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des niveaux d'études");
        $breads   = [];
        $breads[] = ['name' => 'Niveaux', 'url' => 'level_homepage'];
        $this->setBreadcrumbs($breads);
        
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
     * @Route("/level/add", name="level_add")
     *
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
        $breads[] = ['name' => 'Niveaux', 'url' => 'level_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'level_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('level_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/level/update", name="level_upd")
     *
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
        $breads[] = ['name' => 'Niveaux', 'url' => 'level_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'level_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('level_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/level/delete", name="level_del")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('level_homepage');
        
        return parent::deleteRecord();
    }
}