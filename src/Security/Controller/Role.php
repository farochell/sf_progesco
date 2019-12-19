<?php
/*
 * Created on Sat Mar 31 2018
 *
 * Author: Emile Camara <camara.emile@gmail.com>
 */

namespace App\Security\Controller;

use App\Manager\Controller\ManagerController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class Role
 *
 * @package App\Security\Controller
 *
 */
class Role extends ManagerController
{
    public function __construct()
    {
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
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return parent::index();
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(){
        return parent::listRecord();
    }

    /**
     * @Route("/role-ajout", name="role_add")
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add ()
    {
        $this->setUrl('role_homepage');
        return parent::addRecord();
    }

    /**
     * @Route("/role-modification", name="role_upd")
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(){
        $this->setUrl('role_homepage');
        return parent::updateRecord();
    }

    /**
     * @Route("/role-suppression", name="role_del")
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(){
        $this->setUrl('role_homepage');
        return parent::delete();
    }
}