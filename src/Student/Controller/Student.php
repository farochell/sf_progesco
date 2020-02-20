<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   27/12/2019
 * @time  :   14:13
 */

namespace App\Student\Controller;

use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Student\Service\StudentService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class Student
 *
 * @package App\Student\Controller
 * @Route("/admin")
 */
class Student extends ManagerController {
    /**
     * Student constructor.
     *
     * @param OrmService          $ormService
     * @param StudentService      $studentService
     * @param LoggerInterface     $logger
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     */
    public function __construct(OrmService $ormService, StudentService $studentService,LoggerInterface $logger, Breadcrumbs $breadcrumbs, TranslatorInterface $translator) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($studentService);
        $this->setController('Student');
        $this->setBundle('App\\Student\\Controller');
        $this->setEntityNamespace('App\\Student');
        $this->setEntityName('Student');
        $this->setMenuItem('Student');
        $this->setMenuGroup('Student');
        $this->setTag('@student');
    }
    
    /**
     * @Route("/students", name="student_homepage")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT_SHOW')")
     *
     * @return Response
     */
    public function home() {
        
        $breads   = [];
        $breads[] = ['name' => 'Etudiants', 'url' => 'student_homepage'];
        $this->setBreadcrumbs($breads);
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des étudiants");
        $this->setTableType('table.html.twig');
        
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
     * @Route("/students/add", name="student_add")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT_ADD')")
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Etudiants', 'url' => 'student_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'student_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('student_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/students/update", name="student_upd")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT_UPD')")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Etudiants', 'url' => 'student_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'student_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('student_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/students/delete", name="student_del")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT_DEL')")
     *
     * @param OrmService $ormService
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('student_homepage');
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/students/edit", name="student_edit")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT_SHOW')")
     * @return Response
     */
    public function detail() {
        $breads   = [];
        $breads[] = ['name' => 'Etudiants', 'url' => 'student_homepage'];
        $breads[] = ['name' => 'Fiche', 'url' => 'student_edit'];
        $this->setBreadcrumbs($breads);
        
        return parent::edit();
    }
}