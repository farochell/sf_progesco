<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   08/02/2020
 * @time  :   13:20
 */

namespace App\Scoring\Controller;


use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use App\Scoring\Service\ClassNoteFormService;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ClassNoteForm
 *
 * @package App\Scoring\Controller
 * @Route("/admin")
 */
class ClassNoteForm extends ManagerController {
    
    /**
     * ClassNoteForm constructor.
     *
     * @param OrmService           $ormService
     * @param TranslatorInterface  $translator
     * @param LoggerInterface      $logger
     * @param Breadcrumbs          $breadcrumbs
     * @param ClassNoteFormService $classNoteFormService
     */
    public function __construct(
        OrmService $ormService,
        TranslatorInterface $translator,
        LoggerInterface $logger,
        Breadcrumbs $breadcrumbs,
        ClassNoteFormService $classNoteFormService
    ) {
        parent::__construct($ormService, $translator, $logger, $breadcrumbs);
        $this->setService($classNoteFormService);
        $this->setController('ClassNoteForm');
        $this->setBundle('App\\Scoring\\Controller');
        $this->setEntityNamespace('App\\Scoring');
        $this->setEntityName('ClassNoteForm');
        $this->setMenuItem('ClassNoteForm');
        $this->setMenuGroup('Scoring');
        $this->setTag('@scoring');
    }
    
    /**
     * @param $params
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getClassNoteFormsByClassNote($params){
        return parent::customFunction("getClassNoteFormsByClassNote", $params);
    }
    
    /**
     * @Route("/classnoteforms/update", name="classnoteform_upd")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function update() {
        $breads   = [];
        $breads[] = ['name' => 'Notes', 'url' => 'classnote_homepage'];
        $breads[] = ['name' => 'Fiche', 'url' => 'classnote_form', 'params' => ['id' => $this->getRequest()->get('class_note_id')]];
        $breads[] = ['name' => 'Formulaire modification', 'url' => 'classnoteform_upd'];
        $this->setBreadcrumbs($breads);
        $this->setUrl('classnote_form', ['id' => $this->getRequest()->get('class_note_id')]);
        
        return parent::updateRecord();
    }
    
    /**
     * @Route("/classnoteforms/delete", name="classnoteform_del")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return JsonResponse|RedirectResponse
     */
    public function delete() {
        $this->setUrl('classnote_form', ['id' => $this->getRequest()->get('class_note_id')]);
        
        return parent::deleteRecord();
    }
}