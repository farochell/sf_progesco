<?php
/*
 * Created on Sat Mar 31 2018
 *
 * Author: Emile Camara <camara.emile@gmail.com>
 */

namespace App\Security\Controller;

use App\Security\Entity\Role;
use App\Security\Entity\User;
use Symfony\Component\Form\FormError;
use App\Security\Form\AddUserRoleType;
use App\Manager\Controller\ManagerController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * UserRole class
 * @Route("/admin")
 */
class UserRole extends ManagerController
{
    /**
     * Constructeur par défaut de la classe Etudiant
     */
    public function __construct()
    {
        $this->setController('UserRole');
        $this->setBundle('App\\Security\\Controller');
        $this->setEntityNamespace('App\\Security');
        $this->setMenuItem('User');
        $this->setMenuGroup('Security');
        $this->setEntityName('User');
        $this->setTag('@security');
        $this->setService('user.service');
        $this->setOrmService('execute_service');
    }
    
    public function listUserRoles() {
        return parent::customFunction("listUserRoles");
    }

    /**
     * addUserRole function
     * @Route("user-role-ajout", name="add_role_user")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addUserRole() {
        $this->setController('SecurityApp');
        $params = $this->getParams();
        $form = $this->createForm(AddUserRoleType::class, null, $params);
        $response = new JsonResponse();
        $form->handleRequest($this->getRequest());
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $form['user']->getData();
                $roles = $form['roles']->getData();
                $em = $this->getDoctrine()->getManager();  
                if($roles) {
                    foreach($roles as $role){
                        $user->addRole($role); 
                    }
                }         
                          
                $em->flush();
                
                return $this->redirectToRoute('user_detail', ['id' => $user->getId()]);
            } catch(\Exception $e) {
                $form->get('roles')->addError(new FormError($e->getMessage()));
            }
        }

        $this->setTemplate('form-role-user.html.twig');
        return $this->render($this->getTag() . '\\' . $this->getController() . '\\' . $this->getTemplate(), [
            'form' => $form->createView(),
            'menuItem' => $this->getMenuItem(),
            'menuGroup' => $this->getMenuGroup()
        ]);
    }

    /**
     * updUserRole function
     * @Route("user-role-suppression", name="user_role_del")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delUserRole() {
        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getRequest()->get('user_id'));
        $role = $this->getDoctrine()->getRepository(Role::class)->find($this->getRequest()->get('role_id'));
        $em = $this->getDoctrine()->getManager();       
        $user->removeRole($role);       
        $em->flush();
        return $this->redirectToRoute('user_detail', ['id' => $user->getId()]);
    }
}