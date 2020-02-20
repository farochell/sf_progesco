<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   19/02/2020
 */

namespace App\Pedagogy\Controller;

use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Pedagogy\Service\HourlyVolumeService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * Class HourlyVolume
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class HourlyVolume extends ManagerController {
    
    /**
     * HourlyVolume constructor.
     *
     * @param HourlyVolumeService $hourlyVolumeService
     * @param OrmService          $ormService
     * @param LoggerInterface     $logger
     * @param Breadcrumbs         $breadcrumbs
     * @param TranslatorInterface $translator
     */
    public function __construct(
        HourlyVolumeService $hourlyVolumeService,
        OrmService $ormService,
        LoggerInterface $logger,
        Breadcrumbs $breadcrumbs,
        TranslatorInterface $translator
    ) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($hourlyVolumeService);
        $this->setController('HourlyVolume');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('HourlyVolume');
        $this->setMenuItem('HourlyVolume');
        $this->setMenuGroup('Pedagogy');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/hourlyvolumes", name="hourly_volume_homepage")
     *
     * @return Response
     */
    public function home() {
        
        $breads   = [];
        $breads[] = ['name' => $this->getTranslator()->trans('Volumes horaires des matières'), 'url' => 'hourly_volume_homepage'];
        $this->setBreadcrumbs($breads);
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle($this->getTranslator()->trans("Liste des volumes horaires des matières"));
        
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
     * @Route("/hourlyvolumes/add", name="hourly_volume_add")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => $this->getTranslator()->trans('Volumes horaires des matières'), 'url' => 'hourly_volume_homepage'];
        $breads[] = ['name' => $this->getTranslator()->trans('Formulaire ajout'), 'url' => 'hourly_volume_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('hourly_volume_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/hourlyvolumes/update", name="hourly_volume_upd")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => $this->getTranslator()->trans('Volumes horaires des matières'), 'url' => 'hourly_volume_homepage'];
        $breads[] = ['name' => $this->getTranslator()->trans('Formulaire modification'), 'url' => 'hourly_volume_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('hourly_volume_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/hourlyvolumes/delete", name="hourly_volume_del")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('group_homepage');
        
        return parent::deleteRecord();
    }
}