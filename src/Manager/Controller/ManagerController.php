<?php

namespace App\Manager\Controller;

use App\Manager\Model\UrlModel;
use App\Manager\Service\OrmService;
use App\Manager\Util\Constant;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * Class ManagerController
 * @package App\Manager\Controller
 */
class ManagerController extends AbstractController {
    /**
     *
     * @var string
     */
    private $menuItem;
    
    /**
     *
     * @var string
     */
    private $menuGroup;
    
    /**
     *
     * @var string
     */
    private $controller;
    
    /**
     *
     * @var string
     */
    private $bundle;
    
    /**
     *
     * @var string
     */
    private $entityName;
    
    /**
     *
     * @var string
     */
    private $entityType;
    
    /**
     *
     * @var array
     */
    private $data;
    
    /**
     *
     * @var UrlModel
     */
    private $url;
    
    /**
     *
     * @var object
     */
    private $request;
    
    /**
     *
     * @var string
     */
    private $service;
    
    /**
     *
     * @var array
     */
    private $buttons = [];
    
    /**
     *
     * @var array
     */
    private $actions = [];
    
    /**
     *
     * @var string
     */
    private $entityNamespace;
    
    /**
     *
     * @var string
     */
    private $tag;
    
    /**
     *
     * @var boolean
     */
    private $toEdit = false;
    
    /**
     *
     * @var string
     */
    private $ormService;
    
    /**
     * Undocumented variable
     *
     * @var string
     */
    private $template;
    
    /**
     *
     * @var string
     */
    private $env;
    
    /**
     *
     * @var string
     */
    private $envTemplate;
    
    /**
     *
     * @var string
     */
    private $breadcrumbs;
    
    /**
     * Titre du composant card
     *
     * @var string
     */
    private $cardTitle;
    
    /**
     * @var string
     */
    private $tableType;
    
    /**
     * @var
     */
    private $breadcrumbService;
    
    /**
     * @var
     */
    private $useDefault;
    
    /**
     * @var TranslatorInterface
     */
    private $translator;
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    /**
     * @var boolean
     */
    private $displayTabs;
    
    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getMenuItem(): ?string {
        return $this->menuItem;
    }
    
    /**
     *
     * @return string
     */
    public function getMenuGroup(): ?string {
        return $this->menuGroup;
    }
    
    /**
     *
     * @return string
     */
    public function getController(): string {
        return $this->controller;
    }
    
    /**
     *
     * @return string
     */
    public function getBundle(): string {
        return $this->bundle;
    }
    
    /**
     *
     * @return string
     */
    public function getEntityName(): string {
        return $this->entityName;
    }
    
    /**
     *
     * @return string
     */
    public function getEntityType(): string {
        return $this->entityType;
    }
    
    /**
     *
     * @return array|Object
     */
    public function getData() {
        return $this->data;
    }
    
    /**
     *
     * @return string
     */
    public function getTag(): string {
        return $this->tag;
    }
    
    /**
     *
     * @return object
     */
    public function getRequest(): object {
        return $this->get('request_stack')->getCurrentRequest();
    }
    
    /**
     *
     * @param string $menuItem
     */
    public function setMenuItem(string $menuItem) {
        $this->menuItem = $menuItem;
    }
    
    /**
     *
     * @param string $menuGroup
     */
    public function setMenuGroup(string $menuGroup) {
        $this->menuGroup = $menuGroup;
    }
    
    /**
     *
     * @param string $controller
     */
    public function setController(string $controller) {
        $this->controller = $controller;
    }
    
    /**
     *
     * @param string $bundle
     */
    public function setBundle(string $bundle) {
        $this->bundle = $bundle;
    }
    
    /**
     *
     * @param string $entityName
     */
    public function setEntityName(string $entityName) {
        $this->entityName = $entityName;
    }
    
    /**
     *
     * @param string $entityType
     */
    public function setEntityType(string $entityType) {
        $this->entityType = $entityType;
    }
    
    /**
     *
     * @param array|Object $data
     */
    public function setData($data) {
        $this->data = $data;
    }
    
    /**
     *
     * @param object $request
     */
    public function setRequest($request) {
        $this->request = $request;
    }
    
    /**
     *
     * @return string
     */
    public function getService() {
        return $this->service;
    }
    
    /**
     *
     * @param object $service
     */
    public function setService($service) {
        $this->service = $service;
    }
    
    /**
     *
     * @return array
     */
    public function getActions(): array {
        return $this->actions;
    }
    
    /**
     *
     * @param array $action
     */
    public function addAction(array $action) {
        $this->actions[] = $action;
    }
    
    /**
     *
     * @return array
     */
    public function getButtons(): array {
        return $this->buttons;
    }
    
    /**
     *
     * @param array $buttons
     */
    public function setButtons(array $buttons) {
        $this->buttons = $buttons;
    }
    
    /**
     *
     * @return string
     */
    public function getEntityNamespace(): string {
        return $this->entityNamespace;
    }
    
    /**
     *
     * @param string $entityNamespace
     */
    public function setEntityNamespace(string $entityNamespace) {
        $this->entityNamespace = $entityNamespace;
    }
    
    /**
     *
     * @return string
     */
    public function getEntityNamePath(): string {
        $path = $this->entityNamespace.'\Entity\ '.$this->getEntityName();
        
        return str_replace(' ', '', $path);
    }
    
    /**
     * Récupération de l'EntityType
     *
     * @return string
     */
    public function getEntityTypePath(): string {
        $path = $this->entityNamespace.'\Form\ '.$this->getEntityName().'Type';
        
        return str_replace(' ', '', $path);
    }
    
    /**
     *
     * @param string $tag
     */
    public function setTag(string $tag) {
        $this->tag = $tag;
    }
    
    /**
     *
     * @param string $url
     * @param array  $params
     */
    public function setUrl(string $url, array $params = []) {
        $this->url = new UrlModel($url, $params);
    }
    
    /**
     *
     * @return UrlModel
     */
    public function getUrl() {
        return $this->url;
    }
    
    /**
     *
     * @return bool
     */
    public function getToEdit(): bool {
        return $this->toEdit;
    }
    
    /**
     *
     * @param boolean $toEdit
     */
    public function setToEdit(bool $toEdit = false) {
        $this->toEdit = $toEdit;
    }
    
    /**
     * Retourne la liste des paramètres
     *
     * @return array
     */
    public function getParams(): array {
        return $this->getRequest()->query->all();
    }
    
    /**
     * @return string
     */
    public function getOrmService() {
        return $this->ormService;
    }
    
    /**
     * @param  $ormService
     */
    public function setOrmService($ormService) {
        $this->ormService = $ormService;
    }
    
    /**
     * @return mixed
     */
    public function getUseDefault() {
        return ($this->useDefault === null) ? true : $this->useDefault;
    }
    
    /**
     * @param mixed $useDefault
     */
    public function setUseDefault($useDefault): void {
        $this->useDefault = $useDefault;
    }
    
    /**
     * getTemplate
     *
     * @return  string
     */
    public function getTemplate() {
        return $this->template;
    }
    
    /**
     * Set setTemplate
     *
     * @param string $template Undocumented variable
     *
     * @return  self
     */
    public function setTemplate(string $template) {
        $this->template = $template;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getPreviousUri() {
        // Récupération de l'historique de navigation
        $history = $this->getRequest()->getSession()->get('uri');
        if ($history) {
            return $history;
        } else {
            return '';
        }
    }
    
    /**
     *
     * @return string
     */
    public function getEnvTemplate(): string {
        if ($this->envTemplate == "") {
            $this->envTemplate = "base.html.twig";
        }
        
        return $this->envTemplate;
    }
    
    /**
     *
     * @param string $env
     */
    public function setEnv(string $env) {
        $this->env = $env;
    }
    
    /**
     *
     * @param string $envTemplate
     */
    public function setEnvTemplate(string $envTemplate) {
        $this->envTemplate = $envTemplate;
    }
    
    /**
     * Get the value of breadcrumbs
     *
     * @return  string
     */
    public function getBreadcrumbs() {
        return $this->breadcrumbs;
    }
    
    /**
     * @param array $breadcrumbs
     */
    public function setBreadcrumbs(array $breadcrumbs) {
        $this->breadcrumbs = $this->getBreadcrumbService();
        foreach ($breadcrumbs as $bread) {
            $this->breadcrumbs->addRouteItem(
                $bread["name"], $bread["url"],
                (isset($breadcrumbs["params"])) ? $breadcrumbs["params"] : []
            );
        }
    }
    
    /**
     * @return string
     */
    public function getCardTitle(): ?string {
        return $this->cardTitle;
    }
    
    /**
     * @param string $cardTitle
     *
     * @return ManagerController
     */
    public function setCardTitle(string $cardTitle): ManagerController {
        $this->cardTitle = $cardTitle;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getTableType(): ?string {
        if ($this->tableType == null) {
            $this->tableType = 'table.ajax.html.twig';
        }
        
        return $this->tableType;
    }
    
    /**
     * @param string $tableType
     *
     * @return ManagerController
     */
    public function setTableType(string $tableType): ManagerController {
        $this->tableType = $tableType;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getBreadcrumbService() {
        return $this->breadcrumbService;
    }
    
    /**
     * @param mixed $breadcrumbService
     */
    public function setBreadcrumbService($breadcrumbService): void {
        $this->breadcrumbService = $breadcrumbService;
    }
    
    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface {
        return $this->logger;
    }
    
    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void {
        $this->logger = $logger;
    }
    
    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface {
        return $this->translator;
    }
    
    /**
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator): void {
        $this->translator = $translator;
    }
    
    /**
     * @return bool
     */
    public function isDisplayTabs(): bool {
        return (isset($this->displayTabs)?$this->displayTabs:false);
    }
    
    /**
     * @param bool $displayTabs
     */
    public function setDisplayTabs(bool $displayTabs): void {
        $this->displayTabs = $displayTabs;
    }
    
    /**
     * Fonction permettant d'afficher la page principale d'un menu
     *
     * @return Response
     */
    public function index() {
        $service = $this->getService();
        if (method_exists($service, 'addButton')) {
            $this->buttons[] = $service->addButton();
        }
        
        return $this->render(
            '@manager/index.html.twig', [
            Constant::CTRL_LABEL        => $this->getController(),
            Constant::BUNDLE_LABEL      => $this->getBundle(),
            Constant::MENUITEM_LABEL    => $this->getMenuItem(),
            Constant::MENUGROUP_LABEL   => $this->getMenuGroup(),
            Constant::BUTTONS_LABEL     => $this->getButtons(),
            Constant::ACTIONS_LABEL     => $this->getActions(),
            Constant::BREADCRUMBS_LABEL => $this->getBreadcrumbs(),
            Constant::ENVTEMPLATE_LABEL => $this->getEnvTemplate(),
            Constant::DISPLAY_TABS      => $this->isDisplayTabs()
        ]
        );
    }
    
    /**
     * Allow to show records list
     *
     * @param array $param
     *
     * @return Response
     */
    public function listRecord(array $param = []) {
        if ($param == null) {
            $response = $this->get($this->getService())
                             ->findAll();
        } else {
            $response = $this->get($this->getService())
                             ->findBy($param);
        }
        
        return $this->render(
            '@manager/list.html.twig', [
            Constant::PAGINATION_LABEL => $response['pagination'],
            Constant::TABLE_LABEL      => $response['table'],
            Constant::CARDTITLE_LABEL  => $this->getTranslator()->trans($this->getCardTitle()),
            Constant::TABLETYPE_LABEL  => $this->getTableType(),
            Constant::FORM_LABEL       => (isset($response['form']) ? $response['form'] : ''),
        ]
        );
    }
    
    /**
     * Allow tow show record with a call of custom function
     *
     * @param string $functionName
     * @param null   $params
     *
     * @return Response
     */
    public function customFunction($functionName, $params = null) {
        $response = $this->getService()->$functionName($params);
        
        return $this->render(
            '@manager/list.html.twig', [
            Constant::PAGINATION_LABEL => $response['pagination'],
            Constant::CARDTITLE_LABEL  => $this->getTranslator()->trans($this->getCardTitle()),
            Constant::TABLETYPE_LABEL  => $this->getTableType(),
            Constant::TABLE_LABEL      => $response['table'],
            Constant::CTRL_LABEL       => $this->getController(),
            Constant::TAG_LABEL        => $this->getTag(),
            Constant::FORM_LABEL       => (isset($response['form']) ? $response['form'] : ''),
        ]
        );
    }
    
    /**
     * Allow to add a new record
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    public function addRecord() {
        $request    = $this->getRequest();
        $entityName = $this->getEntityNamePath();
        
        $params = $this->getParams();
        $entity = new $entityName();
        
        $entityType = $this->getEntityTypePath();
        $form       = $this->createForm($entityType, $entity, $params);
        $response   = new JsonResponse();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUseDefault() == true) {
                $response = $this->getOrmService()->add($form, $entity, $response);
            } else {
                $response = $this->getService()->add($form, $entity, $response);
            }
            
            // Decodage du json renvoyé
            $content = json_decode($response->getContent());
            // L'enregistrement s'est bien effectué
            if ($content->status == 'OK') {
                if (null !== $this->getUrl() && $this->getUrl() != '') {
                    if ($this->toEdit == true) {
                        $params = [
                            'id' => $entity->getId(),
                        ];
                        $this->url->setParams($params);
                        
                        return $this->redirectToRoute($this->url->getUrl(), $this->url->getParams());
                    } else {
                        return $this->redirectToRoute($this->url->getUrl(), $this->url->getParams());
                    }
                }
            } else {
                $form->addError(new FormError($content->message));
            }
        }
        
        if ($this->template == "") {
            $this->template = "form.html.twig";
        }
        
        return $this->render(
            $this->getTag().'\\'.$this->getController().'\\'.$this->template, [
            Constant::FORM_LABEL        => $form->createView(),
            Constant::MENUITEM_LABEL    => $this->getMenuItem(),
            Constant::MENUGROUP_LABEL   => $this->getMenuGroup(),
            Constant::ENVTEMPLATE_LABEL => $this->getEnvTemplate(),
            Constant::PREVIOUSURL_LABEL => $this->getPreviousUri(),
        ]
        );
    }
    
    /**
     * Fonction permettant de mettre à jour un enregistrement
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    public function updateRecord() {
        $request = $this->getRequest();
        $params  = $this->getParams();
        
        $entity     = $this->getDoctrine()
                           ->getRepository($this->getEntityNamePath())
                           ->find($params['id']);
        $entityType = $this->getEntityTypePath();
        $form       = $this->createForm($entityType, $entity, $params);
        
        $response = new JsonResponse();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Execution de la fonction d'update
            $response = $this->getOrmService()->update($form, $response);
            // Decodage du json renvoyé
            $content = json_decode($response->getContent());
            // L'enregistrement s'est bien effectué
            if ($content->status == 'OK') {
                if (null !== $this->getUrl() && $this->getUrl() != '') {
                    if ($this->toEdit == true) {
                        $params = [
                            'id' => $entity->getId(),
                        ];
                        $this->url->setParams($params);
                        
                        return $this->redirectToRoute($this->url->getUrl(), $this->url->getParams());
                    } else {
                        return $this->redirectToRoute($this->url->getUrl(), $this->url->getParams());
                    }
                }
            }
        }
        
        if ($this->template == "") {
            $this->template = "form.html.twig";
        }
        
        return $this->render(
            $this->getTag().'\\'.$this->getController().'\\'.$this->template, [
            Constant::FORM_LABEL        => $form->createView(),
            Constant::MENUITEM_LABEL    => $this->getMenuItem(),
            Constant::MENUGROUP_LABEL   => $this->getMenuGroup(),
            Constant::ENVTEMPLATE_LABEL => $this->getEnvTemplate(),
            Constant::PREVIOUSURL_LABEL => $this->getPreviousUri(),
        ]
        );
    }
    
    /**
     * @return JsonResponse|RedirectResponse
     */
    protected function deleteRecord() {
        $request  = $this->getRequest();
        $id       = $request->get('id');
        $entity   = $this->getDoctrine()
                         ->getRepository($this->getEntityNamePath())
                         ->find($id);
        $response = new JsonResponse();
        $return   = $this->getOrmService()->delete($entity, $response);
        
        // Decodage du json renvoyé
        $content = json_decode($return->getContent());
        if ($content->status == 'OK') {
            if (null !== $this->getUrl() && $this->getUrl() != '') {
                if ($this->toEdit == true) {
                    $params = [
                        'id' => $entity->getId(),
                    ];
                    $this->url->setParams($params);
                    
                    return $this->redirectToRoute($this->url->getUrl(), $this->url->getParams());
                } else {
                    return $this->redirectToRoute($this->url->getUrl(), $this->url->getParams());
                }
            }
        } else {
            return $this->redirectToRoute($this->url->getUrl(), $this->url->getParams());
        }
        
    }
    
    /**
     * @return Response
     */
    public function edit() {
        $data = $this->getService()->find();
        $this->setData($data);
        
        if ($this->template == "") {
            $this->template = "fiche.html.twig";
        }
        
        return $this->render(
            $this->getTag().'\\'.$this->getController().'\\'.$this->template,
            [
                Constant::CTRL_LABEL        => $this->getController(),
                Constant::BUNDLE_LABEL      => $this->getBundle(),
                Constant::MENUITEM_LABEL    => $this->getMenuItem(),
                Constant::MENUGROUP_LABEL   => $this->getMenuGroup(),
                Constant::DATA_LABEL        => $this->getData(),
                Constant::TAG_LABEL         => $this->getTag(),
                Constant::TEMPLATE_LABEL    => $this->getTemplate(),
                Constant::ENTITYNAME_LABEL  => $this->getEntityName(),
                Constant::ENVTEMPLATE_LABEL => $this->getEnvTemplate(),
                Constant::PREVIOUSURL_LABEL => $this->getPreviousUri(),
            ]
        );
    }
    
    
    /**
     * ManagerController constructor.
     *
     * @param OrmService          $ormService
     * @param TranslatorInterface $translator
     * @param LoggerInterface     $logger
     * @param Breadcrumbs         $breadcrumbs
     */
    public function __construct(OrmService $ormService, TranslatorInterface $translator, LoggerInterface $logger, Breadcrumbs $breadcrumbs ) {
        $this->setOrmService($ormService);
        $this->setTranslator($translator);
        $this->setLogger($logger);
        $this->setBreadcrumbService($breadcrumbs);
    }
}