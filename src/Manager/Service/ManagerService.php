<?php

namespace App\Manager\Service;

use App\IHM\Model\Table\Cell;
use App\IHM\Model\Table\CellAction;
use App\IHM\Model\Table\CellAttribute;
use App\IHM\Model\Table\Row;
use App\IHM\Model\Table\Table;
use App\Pedagogy\Helper\SchoolYearHelper;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ManagerService
 * @package App\Manager\Service
 */
class ManagerService {
    /**
     */
    const PER_PAGE = 10;
    
    /**
     *
     * @var string|ContainerInterface
     */
    private $container = '';
    
    /**
     *
     * @var object|string
     */
    private $em = '';
    
    /**
     *
     * @var object|string
     */
    private $request = '';
    
    /**
     *
     * @var object|\App\IHM\Model\Table\Cell
     */
    private $cell;
    
    /**
     *
     * @var object|Row
     */
    private $row;
    
    /**
     *
     * @var object
     */
    private $table;
    
    /**
     *
     * @var object|\App\IHM\Model\Table\CellAction
     */
    private $cellAction;
    
    /**
     *
     * @var object|\App\IHM\Model\Table\CellAttribute
     */
    private $cellAttribute;
    
    /**
     *
     * @var array
     */
    private $buttons = [];
    
    /**
     *
     * @var
     */
    private $paginator;
    
    /**
     * @var Security
     */
    private $security;
    
    /**
     * @var RouterInterface|null
     */
    private $router;
    
    /**
     * @var SchoolYearHelper
     */
    private $schoolYearHelper;
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    /**
     * @var Serializer
     */
    private $serializer;
    
    private $translator;
    
    /**
     *
     * @return mixed
     */
    public function getPaginator() {
        return $this->paginator;
    }
    
    /**
     */
    public function setPaginator() {
        $this->paginator = $this->container->get('knp_paginator');
    }
    
    /**
     *
     * @return array
     */
    public function getButtons() {
        return $this->buttons;
    }
    
    /**
     * @param $button
     */
    public function setButtons($button) {
        $this->buttons[] = $button;
    }
    
    /**
     *
     * @param string $id
     *
     * @return object|\App\IHM\Model\Table\Table
     */
    public function getTable(string $id) {
        $this->table = new Table($id);
        
        return $this->table;
    }
    
    /**
     * @param string        $name
     * @param string|Object $value
     * @param string        $className
     * @param string        $format
     *
     * @return Cell|object
     */
    public function getCell(string $name, $value = "", string $className = "", string $format = "string") {
        $this->cell = new Cell($name, $value, $className, $format);
        
        return $this->cell;
    }
    
    /**
     *
     * @param string $name
     * @param string $type
     *
     * @return object|\App\IHM\Model\Table\CellAction
     */
    public function getCellAction(string $name, string $type) {
        $this->cellAction = new CellAction($name, $type);
        
        return $this->cellAction;
    }
    
    /**
     *
     * @param string $icon
     * @param string $title
     * @param string $url
     * @param string $color
     * @param string $ajax
     * @param array  $params
     *
     * @return object|\App\IHM\Model\Table\CellAttribute
     */
    public function getCellAttribute(
        string $icon,
        string $title,
        string $url = "",
        string $color = "btn-dark",
        string $ajax = "",
        array $params = []
    ) {
        $this->cellAttribute = new CellAttribute($icon, $title, $url, $color, $params);
        
        if ($ajax != null) {
            $this->cellAttribute->setAjax($ajax);
        }
        
        return $this->cellAttribute;
    }
    
    /**
     *
     * @param string $id
     *
     * @return object|Row
     */
    public function getRow(string $id) {
        $this->row = new Row($id);
        
        return $this->row;
    }
    
    /**
     *
     * @return string|ContainerInterface
     */
    public function getContainer() {
        return $this->container;
    }
    
    /**
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container) {
        $this->container = $container;
    }
    
    /**
     *
     * @return object|string
     */
    public function getEm() {
        return $this->em;
    }
    
    /**
     *
     * @param object|string $em
     */
    public function setEm($em) {
        $this->em = $em;
    }
    
    /**
     *
     * @return object|string
     */
    public function getRequest() {
        return $this->request;
    }
    
    /**
     *
     * @param object|string $request
     */
    public function setRequest($request) {
        $this->request = $request;
    }
    
    /**
     * @return Security
     */
    public function getSecurity(): Security {
        return $this->security;
    }
    
    /**
     * @param Security $security
     */
    public function setSecurity(Security $security): void {
        $this->security = $security;
    }
    
    /**
     * @return SchoolYearHelper
     */
    public function getSchoolYearHelper(): SchoolYearHelper {
        return $this->schoolYearHelper;
    }
    
    /**
     * @param SchoolYearHelper $schoolYearHelper
     */
    public function setSchoolYearHelper(SchoolYearHelper $schoolYearHelper): void {
        $this->schoolYearHelper = $schoolYearHelper;
    }
    
    /**
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface {
        return $this->router;
    }
    
    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router): void {
        $this->router = $router;
    }
    
    /**
     * @return mixed
     */
    public function getLogger() {
        return $this->logger;
    }
    
    /**
     * @param mixed $logger
     */
    public function setLogger($logger): void {
        $this->logger = $logger;
    }
    
    /**
     * @return Serializer
     */
    public function getSerializer(): Serializer {
        return $this->serializer;
    }
    
    /**
     * @param Serializer $serializer
     */
    public function setSerializer(Serializer $serializer): void {
        $this->serializer = $serializer;
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
     * AppAssembler constructor.
     *
     * @param ContainerInterface   $container
     * @param SchoolYearHelper     $schoolYearHelper
     * @param Security             $security
     * @param LoggerInterface      $logger
     * @param TranslatorInterface  $translator
     * @param RouterInterface|null $router
     */
    public function __construct(
        ContainerInterface $container,
        SchoolYearHelper $schoolYearHelper,
        Security $security,
        LoggerInterface $logger,
        TranslatorInterface $translator,
        RouterInterface $router = null
    ) {
        
        $this->container = $container;
        $this->em        = $container->get('doctrine.orm.default_entity_manager');
        $this->request   = $container->get('request_stack')->getCurrentRequest();
        $this->setPaginator();
        $this->schoolYearHelper = $schoolYearHelper;
        $this->security         = $security;
        $this->router           = $router;
        $this->logger           = $logger;
        $encoders               = [new XmlEncoder(), new JsonEncoder()];
        $normalizers            = [new ObjectNormalizer()];
        $this->serializer       = new Serializer($normalizers, $encoders);
        $this->translator       = $translator;
    }
    
}