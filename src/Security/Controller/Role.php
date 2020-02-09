<?php
/*
 * Created on Sat Mar 31 2018
 *
 * Author: Emile Camara <camara.emile@gmail.com>
 */

namespace App\Security\Controller;

use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Security\Service\RoleService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class Role
 *
 * @package App\Security\Controller
 * @Route("/admin")
 */
class Role extends ManagerController {
    /**
     * Role constructor.
     *
     * @param RoleService         $roleService
     * @param OrmService          $ormService
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     */
    public function __construct(RoleService $roleService, OrmService $ormService, Breadcrumbs $breadcrumbs, TranslatorInterface $translator) {
        $this->setService($roleService);
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setTranslator($translator);
        $this->setController('Role');
        $this->setBundle('App\\Security\\Controller');
        $this->setEntityNamespace('App\\Security');
        $this->setMenuItem('Role');
        $this->setMenuGroup('Security');
        $this->setEntityName('Role');
        $this->setTag('@security');
    }
    
    /**
     * @Route("/roles", name="role_homepage")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function home() {
        
        $breads   = [];
        $breads[] = ['name' => 'Liste des rôles', 'url' => 'role_homepage'];
        $this->setBreadcrumbs($breads);
        
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des rôles");
        
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
     * @Route("/role-ajout", name="role_add")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function add() {
        
        $breads   = [];
        $breads[] = ['name' => 'Liste des rôles', 'url' => 'role_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'role_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('role_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/role-modification", name="role_upd")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Liste des rôles', 'url' => 'role_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'role_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('role_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/role-suppression", name="role_del")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function delete() {
        $this->setUrl('role_homepage');
        
        return parent::deleteRecord();
    }
}