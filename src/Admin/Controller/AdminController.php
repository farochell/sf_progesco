<?php


namespace App\Admin\Controller;

use App\Admin\Service\AdminService;
use App\Manager\Controller\ManagerController;
use App\Manager\Util\Constant;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
/**
 * Class AdminController
 * @package App\Admin\Controller
 * emile.camara
 * 16/11/2019

 */
class AdminController extends ManagerController {
    
    /**
     * AdminController constructor.
     *
     * @param AdminService $adminService
     * @param Breadcrumbs  $breadcrumbs
     */
    public function __construct(AdminService $adminService, Breadcrumbs $breadcrumbs) {
        $this->setService($adminService);
        $this->setController('Admin');
        $this->setBundle('App\\Admin\\Controller');
        $this->setBreadcrumbService($breadcrumbs);
        $this->setTag('@admin');
    }
    
    /**
     * @Route("/", name="admin_homepage")
     *
     * @return Response
     */
    public function home() {
        $this->getRequest()
             ->getSession()
             ->set(
                 'uri', $this->getRequest()
                             ->getUri()
             );
        
        
        return $this->render($this->getTag().'/'.$this->getController().'/index.html.twig', []);
    }
    
    /**
     * @Route("/admin/cache-management", name="cache_management")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function cacheManagement() {
        $breads   = [];
        $breads[] = ['name' => 'Gestion du cache', 'url' => 'cache_management'];
        $this->setBreadcrumbs($breads);
        $cache = $this->getService()->getCacheSize();
        
        return $this->render(
            $this->getTag().'/'.$this->getController().'/cache.html.twig', [
                Constant::BREADCRUMBS_LABEL => $this->getBreadcrumbs(),
                'cache'                     => $cache,
            ]
        );
    }
    
    /**
     * @Route("/admin/clear-cache", name="clear_cache")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function clearCache() {
        $this->getService()->clearCache();
        return $this->redirectToRoute('cache_management',[]);
    }
    
}
