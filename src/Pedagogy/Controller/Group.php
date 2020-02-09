<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 16/11/2019
 */

namespace App\Pedagogy\Controller;

use App\Calendar\Service\CalendarService;
use App\Manager\Util\Constant;
use App\Pedagogy\Service\GroupService;
use App\Manager\Service\OrmService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Pedagogy\Entity\Group as GroupEntity;
use App\Manager\Controller\ManagerController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class GroupController
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Group extends ManagerController {
    
    /**
     * GroupController constructor.
     *
     * @param OrmService          $ormService
     * @param Breadcrumbs         $breadcrumbs
     * @param GroupService        $groupService
     * @param TranslatorInterface $translator
     */
    public function __construct(OrmService $ormService, Breadcrumbs $breadcrumbs, GroupService $groupService, TranslatorInterface $translator) {
        $this->setService($groupService);
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $this->setTranslator($translator);
        $this->setController('Group');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Group');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/groups", name="group_homepage")
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
        $breads   = [];
        $breads[] = ['name' => 'Groupes', 'url' => 'group_homepage'];
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des groupes");
        $this->setBreadcrumbs($breads);
        
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
     * @Route("/groups/add", name="group_add")
     *
     *
     * @return Response
     */
    public function add() {
        
        $breads   = [];
        $breads[] = ['name' => 'Groupes', 'url' => 'group_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'group_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('group_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/groups/update", name="group_upd")
     *
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Groupes', 'url' => 'group_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'group_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('group_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/groups/delete", name="group_del")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('group_homepage');
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/groups/scheduler/{id}/{month}/{year}", name="group_schedule")
     * @ParamConverter("group", options={"id" = "id"})
     * @param GroupEntity     $group
     * @param null            $month
     * @param null            $year
     * @param CalendarService $calendarService
     *
     * @return Response
     * @throws \Exception
     */
    public function scheduler(
        GroupEntity $group,
        $month = null,
        $year = null,
        CalendarService $calendarService
    ) {
        
        if ($month == null) {
            $month = date("m");
        }
        if ($year == null) {
            $year = date("Y");
        }
        
        $breads   = [];
        $breads[] = ['name' => 'Groupes', 'url' => 'group_homepage'];
        // $breads[] = array('name' => 'Fiche', 'url' => 'groupe_detail', 'params' => ['id' => $group->getId()]);
        // $breads[] = array('name' => 'Empoi du temps', 'url' => 'groupe_agenda_detail', 'params' => ['id' => $group->getId(), 'month' => $month,
        // 'year' => $year]);
        $this->setBreadcrumbs($breads);
        $agenda = $calendarService->getAgenda();
        $id     = $this->getRequest()->get("id");
        
        $schedules = $this->getService()->getSchedules($agenda);
        
        return $this->render(
            $this->getTag().'/Group/schedule.html.twig',
            [
                'controller' => $this->getController(),
                'bundle'     => $this->getBundle(),
                'menuItem'   => $this->getMenuItem(),
                'menuGroup'  => $this->getMenuGroup(),
                'data'       => $this->getData(),
                'tag'        => $this->getTag(),
                'agenda'     => $agenda,
                'id'         => $id,
                'group'      => $group,
                'template'   => $this->getTemplate(),
                'schedules'  => $schedules,
                'month'      => $month,
                'year'       => $year,
            ]
        );
    }
    
    /**
     * @param GroupService $groupService
     *
     * @return Response
     */
    public function getByLevel(GroupService $groupService) {
        $this->setService($groupService);
        $this->setCardTitle("Liste des groupes");
        
        return parent::customFunction('getByLevel');
    }
    
    /**
     * @Route("/groups/form", name="group_form")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_GROUP_SHOW')")
     *
     * @return Response
     */
    public function detail() {
        
        $breads   = [];
        $breads[] = ['name' => 'Groupes', 'url' => 'group_homepage'];
        $breads[] = ['name' => 'Fiche', 'url' => 'group_form', 'params' => ['id' => $this->getRequest()->get('id')]];
        $this->setBreadcrumbs($breads);
        $this->setTemplate('fiche.html.twig');
        
        $data          = $this->getService()->find();
        $registrations = $this->getService()->getGroupeInfo();
        
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
                'registrations'             => $registrations,
            ]
        );
    }
}