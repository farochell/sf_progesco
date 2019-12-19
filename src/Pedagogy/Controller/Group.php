<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 16/11/2019
 */

namespace App\Pedagogy\Controller;

use App\Calendar\Service\CalendarService;
use App\Pedagogy\Service\GroupService;
use App\Manager\Service\OrmService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Pedagogy\Entity\Group as GroupEntity;
use App\Manager\Controller\ManagerController;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class GroupController
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Group extends ManagerController
{
    /**
     * GroupController constructor.
     */
    public function __construct()
    {
        $this->setController('Group');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Group');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/group", name="group_homepage")
     *
     * @param GroupService $groupService
     *
     * @param Breadcrumbs  $breadcrumbs
     *
     * @return Response
     */
    public function home(GroupService $groupService, Breadcrumbs $breadcrumbs)
    {
        $this->setService($groupService);
        $this->setBreadcrumbService($breadcrumbs);
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
    public function show($params)
    {
        return parent::customFunction("findAll", $params);
    }
    
    /**
     * @Route("/group/add", name="group_add")
     *
     *
     * @param OrmService  $ormService
     *
     * @param Breadcrumbs $breadcrumbs
     *
     * @return Response
     */
    public function add(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Groupes', 'url' => 'group_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'group_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('group_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/group/update", name="group_upd")
     *
     *
     * @param OrmService  $ormService
     *
     * @param Breadcrumbs $breadcrumbs
     *
     * @return Response
     */
    public function update(OrmService $ormService, Breadcrumbs $breadcrumbs)
    {
        $this->setOrmService($ormService);
        $this->setBreadcrumbService($breadcrumbs);
        $breads   = [];
        $breads[] = ['name' => 'Groupes', 'url' => 'group_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'group_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('group_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/group/delete", name="group_del")
     *
     * @param OrmService $ormService
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $this->setUrl('group_homepage');
        
        return parent::deleteRecord();
    }
    
    /**
     * @Route("/group/scheduler/{id}/{month}/{year}", name="group_schedule")
     * @ParamConverter("group", options={"id" = "id"})
     * @param GroupEntity     $group
     * @param null            $month
     * @param null            $year
     * @param GroupService    $groupService
     * @param CalendarService $calendarService
     *
     * @param Breadcrumbs     $breadcrumbs
     *
     * @return Response
     * @throws \Exception
     */
    public function scheduler(GroupEntity $group, $month = null, $year = null, GroupService $groupService, CalendarService $calendarService,
        Breadcrumbs $breadcrumbs) {
        $this->setService($groupService);
        $this->setBreadcrumbService($breadcrumbs);
        if ($month == null) {
            $month = date("m");
        }
        if ($year == null) {
            $year = date("Y");
        }
    
        $breads = array();
        $breads[] = array('name' => 'Groupes', 'url' => 'group_homepage');
        // $breads[] = array('name' => 'Fiche', 'url' => 'groupe_detail', 'params' => ['id' => $group->getId()]);
        // $breads[] = array('name' => 'Empoi du temps', 'url' => 'groupe_agenda_detail', 'params' => ['id' => $group->getId(), 'month' => $month,
        // 'year' => $year]);
        $this->setBreadcrumbs($breads);
        $agenda = $calendarService->getAgenda();
        $id = $this->getRequest()->get("id");
    
        $schedules = $this->getService()->getSchedules($agenda);
        return $this->render(
            $this->getTag().'/Group/schedule.html.twig',
            [
                'controller'      => $this->getController(),
                'bundle'          => $this->getBundle(),
                'menuItem'        => $this->getMenuItem(),
                'menuGroup'       => $this->getMenuGroup(),
                'data'            => $this->getData(),
                'tag'             => $this->getTag(),
                'agenda'          => $agenda,
                'id'              => $id,
                'group'           => $group,
                'template'        => $this->getTemplate(),
                'schedules'       => $schedules,
                'month'           => $month,
                'year'            => $year,
            ]
        );
    }
    
    /**
     * @param GroupService $groupService
     *
     * @return Response
     */
    public function getByLevel(GroupService $groupService)
    {
        $this->setService($groupService);
        $this->setCardTitle("Liste des groupes");
        
        return parent::customFunction('getByLevel');
    }
}