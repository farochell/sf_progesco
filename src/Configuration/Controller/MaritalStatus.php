<?php
/**
 * sf_progesco
 *
 * emile.camara
 * 18/11/2019
 */

namespace App\Configuration\Controller;

use App\Configuration\Service\GenderService;
use App\Configuration\Service\MaritalStatusService;
use App\Manager\Controller\ManagerController;
use App\Manager\Service\OrmService;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class MaritalStatus
 *
 * @package App\Configuration\Controller
 * @Route("/admin")
 */
class MaritalStatus extends ManagerController
{
    /**
     * GenderController constructor.
     */
    public function __construct() {
        $this->setController('MaritalStatus');
        $this->setBundle('App\\Configuration\\Controller');
        $this->setEntityNamespace('App\\Configuration');
        $this->setEntityName('MaritalStatus');
        $this->setService('marital_status.service');
        $this->setTag('@configuration');
    }
    
    /**
     * @Route("/marital-status", name="marital-status_homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(MaritalStatusService $maritalStatusService){
        $this->setService($maritalStatusService);
        $this->addAction(['function' => 'show', 'params' => []]);
        $this->setCardTitle("Liste des situations matrimoniales");
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
     * @Route("/marital-status/add", name="marital-status_add")
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $breads   = [];
        $breads[] = [ 'name' => 'Genres', 'url' => 'marital-status_homepage' ];
        $breads[] = [ 'name' => 'Formulaire ajout', 'url' => 'marital-status_add' ];
        $this->setUrl('marital-status_homepage');
        
        return parent::addRecord();
    }
    
    /**
     * @Route("/marital-status/update", name="marital-status_upd")
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(OrmService $ormService)
    {
        $this->setOrmService($ormService);
        $breads   = [];
        $breads[] = [ 'name' => 'Genres', 'url' => 'marital-status_homepage' ];
        $breads[] = [ 'name' => 'Formulaire modification', 'url' => 'marital-status_upd' ];
        $this->setUrl('marital-status_homepage');
        
        return parent::updateRecord();
    }
}