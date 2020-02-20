<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   25/11/2019
 * @time  :   11:19
 */

namespace App\Classroom\Controller;

use App\Classroom\Service\ClassroomService;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class Classroom
 *
 * @package App\Classroom\Controller
 * @Route("/admin")
 */
class Classroom extends ManagerController {
    /**
     * ClassroomController constructor.
     *
     * @param OrmService          $ormService
     * @param ClassroomService    $classroomService
     * @param Breadcrumbs         $breadcrumbs
     * @param LoggerInterface     $logger
     * @param TranslatorInterface $translator
     */
    public function __construct(OrmService $ormService,
                                ClassroomService $classroomService,
                                Breadcrumbs $breadcrumbs,
                                LoggerInterface $logger,
                                TranslatorInterface $translator) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($classroomService);
        $this->setController('Classroom');
        $this->setBundle('App\\Classroom\\Controller');
        $this->setEntityNamespace('App\\Classroom');
        $this->setEntityName('Classroom');
        $this->setMenuItem('Classroom');
        $this->setMenuGroup('Classroom');
        $this->setTag('@classroom');
    }
    
    /**
     * @Route("/classrooms", name="classroom_homepage")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLASSROOM_SHOW')")
     * @return Response
     */
    public function home() {
        $this->getRequest()
             ->getSession()
             ->set(
                 'uri', $this->getRequest()
                             ->getUri()
             );
        $breads   = [];
        $breads[] = ['name' => 'Salles de classe', 'url' => 'classroom_homepage'];
        $this->setBreadcrumbs($breads);
        
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des salles de classe");
        
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
     * @Route("/classrooms/add", name="classroom_add")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLASSROOM_ADD')")
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Salles de classe', 'url' => 'classroom_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'classroom_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('classroom_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/classrooms/update", name="classroom_upd")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLASSROOM_UPD')")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Salles de classe', 'url' => 'classroom_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'classroom_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('classroom_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/classrooms/delete", name="classroom_del")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLASSROOM_DEL')")
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('classroom_homepage');
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/classrooms/edit", name="classroom_edit")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLASSROOM_SHOW')")
     * @return Response
     */
    public function detail() {
        $breads   = [];
        $breads[] = ['name' => 'Salles de classe', 'url' => 'classroom_homepage'];
        $breads[] = ['name' => 'Fiche', 'url' => 'classroom_edit'];
        $this->setBreadcrumbs($breads);
        
        return parent::edit();
    }
}