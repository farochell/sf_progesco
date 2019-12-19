<?php
/**
 * Created by PhpStorm.
 * User: Emile
 * Date: 03/02/2018
 * Time: 13:14
 */

namespace App\Security\Controller;

use App\Security\Entity\User;
use App\Security\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\Controller\ManagerController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class Security
 * @package App\Configuration\Controller
 */
class SecurityApp extends ManagerController
{
    public function __construct()
    {
        $this->setController('SecurityApp');
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
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
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
            '@security/SecurityApp/form.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/admin/utilisateurs", name="user_homepage")
     * @Security("has_role('ROLE_ADMIN')")
     * @return void
     */
    public function index(){
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
     * @Route("/admin/utilisateur-modification", name="user_upd")
     * @Security("has_role('ROLE_ADMIN')")
     * @return void
     */
    public function upd(Request $request, UserPasswordEncoderInterface $passwordEncoder){
       
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
            '@security/SecurityApp/form.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/utilisateur-detail", name="user_detail")
     * @Security("has_role('ROLE_ADMIN')")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detail()
    {
        $this->setTemplate('SecurityApp');
        return parent::getFiche();
    }
}