<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 16/11/2019
 */

namespace App\Pedagogy\Controller;

use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Pedagogy\Service\GradeService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class GradeController
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Grade extends ManagerController
{
    /**
     * GradeController constructor.
     *
     * @param GradeService        $gradeService
     * @param Breadcrumbs         $breadcrumbs
     * @param OrmService          $ormService
     * @param TranslatorInterface $translator
     */
    public function __construct(GradeService $gradeService, Breadcrumbs $breadcrumbs, OrmService $ormService, TranslatorInterface $translator)
    {
        $this->setService($gradeService);
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setTranslator($translator);
        $this->setController('Grade');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Grade');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/grades", name="grade_homepage")
     *
     * @param GradeService $gradeService
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function home()
    {
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des classes");
        $breads   = [];
        $breads[] = ['name' => 'Classes', 'url' => 'grade_homepage'];
        $this->setBreadcrumbs($breads);
        
        return parent::index();
    }
    
    /**
     * @param $params
     *
     * @return Response
     */
    public function show($params)
    {
        return parent::customFunction("findAll", $params);
    }
    
    /**
     * @Route("/grades/add", name="grade_add")
     *
     *
     * @return Response
     */
    public function add()
    {
        $breads   = [];
        $breads[] = ['name' => 'Classes', 'url' => 'grade_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'grade_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('grade_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/grades/update", name="grade_upd")
     *
     *
     * @return Response
     */
    public function update()
    {
        $breads   = [];
        $breads[] = ['name' => 'Classes', 'url' => 'grade_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'grade_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('grade_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/grades/delete", name="grade_del")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete()
    {
        $this->setUrl('grade_homepage');
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/grades/edit", name="grade_edit")
     * @return Response
     */
    public function detail(){
        $breads = array();
        $breads[] = array('name'=>'Classes','url'=>'grade_homepage');
        $breads[] = array('name'=>'Fiche','url'=>'grade_edit');
        $this->setBreadcrumbs($breads);
        
        return parent::edit();
    }
}