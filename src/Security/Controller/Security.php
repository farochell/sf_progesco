<?php
/**
 * Created by PhpStorm.
 * User: Emile
 * Date: 03/02/2018
 * Time: 13:14
 */

namespace App\Security\Controller;

use App\Manager\Util\Constant;
use App\Security\Entity\User;
use App\Security\Form\UserType;
use App\Security\Service\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\Controller\ManagerController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as SecurityAno;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * Class Security
 * @package App\Configuration\Controller
 */
class Security extends ManagerController
{
    /**
     * SecurityApp constructor.
     */
    public function __construct()
    {
        $this->setController('Security');
        $this->setBundle('App\\Security\\Controller');
        $this->setEntityNamespace('App\\Security');
        $this->setMenuItem('User');
        $this->setMenuGroup('Security');
        $this->setEntityName('User');
        $this->setTag('@security');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('@security/Security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    
    /**
     * @Route("/register", name="user_add")
     * @SecurityAno("has_role('ROLE_ADMIN')")
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @param Breadcrumbs                  $breadcrumbs
     *
     * @return RedirectResponse|Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, Breadcrumbs $breadcrumbs)
    {
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Utilisateurs', 'url' => 'user_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'user_add'];
        $this->setBreadcrumbs($breads);
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
           
            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_homepage');
        }

        return $this->render(
            '@security/Security/form.html.twig',
            ['form' => $form->createView(),
             Constant::PREVIOUSURL_LABEL => $this->getPreviousUri()
            ]
        );
    }
    
    /**
     * @Route("/admin/users", name="user_homepage")
     * @SecurityAno("has_role('ROLE_ADMIN')")
     * @param UserService $userService
     * @param Breadcrumbs $breadcrumbs
     *
     * @return Response
     */
    public function home(UserService $userService, Breadcrumbs $breadcrumbs){
        $this->setService($userService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Utilisateurs', 'url' => 'user_homepage'];
        $this->setBreadcrumbs($breads);
    
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des utilisateurs");
    
        return parent::index();
    }
    
    /**
     * @SecurityAno("has_role('ROLE_ADMIN')")
     * @param $params
     *
     * @return Response
     */
    public function show($params){
        return parent::customFunction("findAll", $params);
    }
    
    /**
     * @Route("/admin/user/update", name="user_upd")
     * @SecurityAno("has_role('ROLE_ADMIN')")
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Breadcrumbs                  $breadcrumbs
     *
     * @return RedirectResponse|Response
     */
    public function upd(Request $request, UserPasswordEncoderInterface $passwordEncoder, Breadcrumbs $breadcrumbs){
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Utilisateurs', 'url' => 'user_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'user_upd'];
        $this->setBreadcrumbs($breads);
        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getRequest()->get('id'));
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
           
            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_homepage');
        }

        return $this->render(
            '@security/Security/form.html.twig',
            ['form' => $form->createView(),
             Constant::PREVIOUSURL_LABEL => $this->getPreviousUri()
            ]
        );
    }
    
    /**
     * @Route("/user/edit", name="user_edit")
     * @SecurityAno("has_role('ROLE_ADMIN')")
     *
     * @param UserService $userService
     * @param Breadcrumbs $breadcrumbs
     *
     * @return Response
     */
    public function detail(UserService $userService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($userService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads = array();
        $breads[] = array('name'=>'Utilisateurs','url'=>'user_homepage');
        $breads[] = array('name'=>'Fiche','url'=>'user_edit');
        $this->setBreadcrumbs($breads);
        $this->setCardTitle("Liste des utilisateurs");
        return parent::edit();
    }
    
    /**
     * @return Response
     */
    public function listUserRoles() {
        return parent::customFunction("listUserRoles");
    }
}