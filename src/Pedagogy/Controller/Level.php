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
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class LevelController
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Level extends ManagerController {
    /**
     * Level constructor.
     *
     * @param LevelService        $levelService
     * @param OrmService          $ormService
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     */
    public function __construct(LevelService $levelService, OrmService $ormService, Breadcrumbs $breadcrumbs, TranslatorInterface $translator) {
        $this->setBreadcrumbService($breadcrumbs);
        $this->setOrmService($ormService);
        $this->setService($levelService);
        $this->setTranslator($translator);
        $this->setController('Level');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Level');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/levels", name="level_homepage")
     *
     * @return Response
     */
    public function home() {
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
    public function show($params) {
        return parent::customFunction("findAll", $params);
    }
    
    /**
     * @Route("/levels/add", name="level_add")
     *
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Niveaux', 'url' => 'level_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'level_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('level_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/levels/update", name="level_upd")
     *
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Niveaux', 'url' => 'level_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'level_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('level_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/levels/delete", name="level_del")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('level_homepage');
        
        return parent::deleteRecord();
    }
}