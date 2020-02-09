<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   11/12/2019
 * @time  :   14:56
 */

namespace App\Teacher\Controller;

use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Teacher\Service\TeacherService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class Teacher
 *
 * @package App\Teacher\Controller
 * @Route("/admin")
 */
class Teacher extends ManagerController {
    /**
     * TeacherController constructor.
     *
     * @param OrmService          $ormService
     * @param TeacherService      $teacherService
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     */
    public function __construct(OrmService $ormService, TeacherService $teacherService, Breadcrumbs $breadcrumbs, TranslatorInterface $translator) {
        $this->setService($teacherService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setOrmService($ormService);
        $this->setTranslator($translator);
        $this->setController('Teacher');
        $this->setBundle('App\\Teacher\\Controller');
        $this->setEntityNamespace('App\\Teacher');
        $this->setEntityName('Teacher');
        $this->setTag('@teacher');
    }
    
    /**
     * @Route("/teacher", name="teacher_homepage")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TEACHER_SHOW')")
     * @return Response
     */
    public function home() {
        
        $breads   = [];
        $breads[] = ['name' => 'Professeurs', 'url' => 'teacher_homepage'];
        $this->setBreadcrumbs($breads);
        
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des professeurs");
        
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
     * @Route("/teacher/add", name="teacher_add")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TEACHER_ADD')")
     *
     * @return Response
     */
    public function add() {
        
        $breads   = [];
        $breads[] = ['name' => 'Professeurs', 'url' => 'teacher_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'teacher_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('teacher_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/teacher/update", name="teacher_upd")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TEACHER_UPD')")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Professeurs', 'url' => 'teacher_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'teacher_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('teacher_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/teacher/delete", name="teacher_del")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TEACHER_DEL')")
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('teacher_homepage');
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/teacher/edit", name="teacher_edit")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TEACHER_SHOW')")
     * @return Response
     */
    public function detail() {
        $breads   = [];
        $breads[] = ['name' => 'Professeurs', 'url' => 'teacher_homepage'];
        $breads[] = ['name' => 'Fiche', 'url' => 'teacher_edit'];
        $this->setBreadcrumbs($breads);
        
        return parent::edit();
    }
}