<?php


namespace App\Admin\Controller;

use App\Manager\Controller\ManagerController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class AdminController
 * @package App\Admin\Controller
 * emile.camara
 * 16/11/2019
 */
class AdminController extends ManagerController
{
    /**
     * AdminController constructor.
     */
    public function __construct() {
        $this->setController('Admin');
        $this->setBundle('App\\Admin\\Controller');
        
        $this->setTag('@admin');
    }
    
    /**
     * @Route("/admin", name="admin_homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home()
    {
        $this->getRequest()
             ->getSession()
             ->set('uri', $this->getRequest()
                               ->getUri());
        
        return $this->render($this->getTag(). '/'. $this->getController().'/index.html.twig', []);
    }
    
}