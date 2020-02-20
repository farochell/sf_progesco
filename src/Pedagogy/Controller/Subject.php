<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   22/11/2019
 * @time  :   17:16
 */

namespace App\Pedagogy\Controller;

use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Pedagogy\Service\SubjectService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * Class Subject
 *
 * @package App\Pedagogy\Controller
 * @Route("/admin")
 */
class Subject extends ManagerController {
    
    /**
     * Subject constructor.
     *
     * @param OrmService          $ormService
     * @param TranslatorInterface $translator
     * @param LoggerInterface     $logger
     * @param Breadcrumbs         $breadcrumbs
     * @param SubjectService      $subjectService
     */
    public function __construct(
        OrmService $ormService,
        TranslatorInterface $translator,
        LoggerInterface $logger,
        Breadcrumbs $breadcrumbs,
        SubjectService $subjectService
    ) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($subjectService);
        $this->setController('Subject');
        $this->setBundle('App\\Pedagogy\\Controller');
        $this->setEntityNamespace('App\\Pedagogy');
        $this->setEntityName('Subject');
        $this->setMenuItem('Subject');
        $this->setMenuGroup('Pedagogy');
        $this->setTag('@pedagogy');
    }
    
    /**
     * @Route("/subjects", name="subject_homepage")
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
        $breads[] = ['name' => 'Matières', 'url' => 'subject_homepage'];
        $this->setBreadcrumbs($breads);
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des matières");
        
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
     * @Route("/subjects/add", name="subject_add")
     *
     *
     * @return Response
     */
    public function add() {
        $breads   = [];
        $breads[] = ['name' => 'Matières', 'url' => 'subject_homepage'];
        $breads[] = ['name' => 'Formulaire ajout', 'url' => 'subject_add'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('subject_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/subjects/update", name="subject_upd")
     *
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Matières', 'url' => 'subject_homepage'];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'subject_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('subject_homepage');
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/subjects/delete", name="subject_del")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('subject_homepage');
        
        return parent::deleteRecord();
    }
}