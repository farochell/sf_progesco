<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/02/2020
 * @time  :   11:55
 */

namespace App\Scoring\Controller;

use App\Manager\Service\OrmService;
use App\Manager\Util\Constant;
use App\Scoring\Service\ClassNoteService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Manager\Controller\ManagerController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * Class ClassNote
 *
 * @package App\Scoring\Controller
 * @Route("/admin")
 */
class ClassNote extends ManagerController {
    
    /**
     * GenderController constructor.
     *
     * @param OrmService          $ormService
     * @param ClassNoteService    $classNoteService
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     * @param LoggerInterface     $logger
     */
    public function __construct(
        OrmService $ormService,
        ClassNoteService $classNoteService,
        Breadcrumbs $breadcrumbs,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ) {
        parent::__construct($ormService,$translator,$logger,$breadcrumbs);
        $this->setService($classNoteService);
        $this->setController('ClassNote');
        $this->setBundle('App\\Scoring\\Controller');
        $this->setEntityNamespace('App\\Scoring');
        $this->setEntityName('ClassNote');
        $this->setTag('@scoring');
    }
    
    /**
     * @Route("/classnotes", name="classnote_homepage")
     * @Security("is_granted('ROLE_ADMIN')")
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
        $this->setDisplayTabs(true);
        $this->addAction(['function' => 'getHomeworkNote', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Devoirs')]]);
        $this->addAction(['function' => 'getExaminationScore', 'params' => [], 'tab' => ['title' => $this->getTranslator()->trans('Examens')]]);
        $this->setCardTitle("Liste des notes");
        $breads   = [];
        $breads[] = ['name' => 'Notes', 'url' => 'classnote_homepage'];
        $this->setBreadcrumbs($breads);
        
        return parent::index();
    }
    
    /**
     * @param $params
     *
     * @return Response
     */
    public function getHomeworkNote($params) {
        return parent::customFunction("getHomeworkNote", $params);
    }
    
    /**
     * @param $params
     *
     * @return Response
     */
    public function getExaminationScore($params) {
        return parent::customFunction("getExaminationScore", $params);
    }
    
    /**
     * @Route("/classnotes/add", name="classnote_add")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Notes', 'url' => 'classnote_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'classnote_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('classnote_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/classnotes/update", name="classnote_upd")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Notes', 'url' => 'classnote_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'classnote_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('classnote_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/classnotes/delete", name="classnote_del")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('classnote_homepage');
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/classnotes/form", name="classnote_form")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLASSNOTE_SHOW')")
     *
     * @return Response
     */
    public function detail() {
       
        $breads   = [];
        $breads[] = ['name' => 'Notes', 'url' => 'classnote_homepage'];
        $breads[] = ['name' => 'Fiche', 'url' => 'classnote_form'];
        $this->setBreadcrumbs($breads);
        $this->setTemplate('fiche.html.twig');
        
        $data          = $this->getService()->find();
        $this->getService()->setClassNoteFormByGradeId();
        
        return $this->render(
            $this->getTag().'\\'.$this->getController().'\\'.$this->getTemplate(),
            [
                Constant::CTRL_LABEL        => $this->getController(),
                Constant::BUNDLE_LABEL      => $this->getBundle(),
                Constant::MENUITEM_LABEL    => $this->getMenuItem(),
                Constant::MENUGROUP_LABEL   => $this->getMenuGroup(),
                Constant::DATA_LABEL        => $data,
                Constant::TAG_LABEL         => $this->getTag(),
                Constant::TEMPLATE_LABEL    => $this->getTemplate(),
                Constant::ENTITYNAME_LABEL  => $this->getEntityName(),
                Constant::ENVTEMPLATE_LABEL => $this->getEnvTemplate(),
                Constant::PREVIOUSURL_LABEL => $this->getPreviousUri(),
            ]
        );
    }
}