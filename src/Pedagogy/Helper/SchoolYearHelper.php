<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   22/11/2019
 * @time  :   14:09
 */

namespace App\Pedagogy\Helper;


use App\Pedagogy\Entity\SchoolYear;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class SchoolYearHelper
 *
 * @package App\Pedagogy\Util
 *
 */
class SchoolYearHelper
{
    /**
     *
     * @var unknown
     */
    private $container;
    
    /**
     *
     * @var unknown
     */
    private $em;
    
    /**
     *
     * @var unknown
     */
    private $request;
    
    /**
     *
     * @return ContainerInterface
     */
    public function getContainer ()
    {
        return $this->container;
    }
    
    /**
     *
     * @return object
     */
    public function getEm ()
    {
        return $this->em;
    }
    
    /**
     *
     * @return mixed
     */
    public function getRequest ()
    {
        return $this->request;
    }
    
    /**
     *
     * @param ContainerInterface $container
     */
    public function setContainer ($container)
    {
        $this->container = $container;
    }
    
    /**
     *
     * @param object $em
     */
    public function setEm ($em)
    {
        $this->em = $em;
    }
    
    /**
     *
     * @param mixed $request
     */
    public function setRequest ($request)
    {
        $this->request = $request;
    }
    
    /**
     *
     * @param ContainerInterface $container
     */
    public function __construct (ContainerInterface $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        $this->request = $container->get('request_stack')->getCurrentRequest();
    }
    
    /**
     *
     * @param int $yearScolaireId
     */
    public function setYear (int $yearScolaireId)
    {
        $this->request->getSession()->set('year', $yearScolaireId);
    }
    
    /**
     *
     */
    public function closeSchoolYear(){
        $em = $this->getEm();
        $em->getConnection()->beginTransaction();
        try{
            $yearToClose = $this->getEm()->getRepository(SchoolYear::class)->findOneBy(['isActive'=>1]);
            
            if($yearToClose) {
                $dateFin = $yearToClose->getDateFin();
                $now = new \DateTime();
                // La date de fin est inférieure à la date du jour
                if($dateFin < $now) {
                    // On doit clôturer l'année scolaire et récupérer l'année à activer
                    $yearToClose->setIsActive(0);
                    $em->flush();
                    $yearToActivateResult = $this->getEm()->getRepository(SchoolYear::class)->findByDateFin($now);
                    if($yearToActivateResult) {
                        $yearToActivate = $this->getEm()->getRepository(SchoolYear::class)->find($yearToActivateResult['id']);
                        $yearToActivate->setIsActive(1);
                        $em->flush();
                    }
                }
                
                $em->getConnection()->commit();
            }
        }catch(\Exception $e) {
            $em->getConnection()->rollback();
            $this->getRequest()->getSession()->getFlashBag()->add('danger',
                'Une erreur est intervenue: '.$e->getMessage());
        }
    }
    
    /**
     * @return int
     */
    public function getPreviousYear() {
        // Récupération de l'avant dernière année
        $year = $this->getEm()->getRepository(SchoolYear::class)->findBy([], ['id' => 'desc'], 2, 1);
        $id = 0;
        if($year) {
            $id = $year[0]->getId();
        }
        
        return $id;
    }
    
    /**
     * @return |null
     */
    public function getCurrentActiveYear() {
        $yearId = null;
        $year = $this->getEm()
                      ->getRepository(SchoolYear::class)
                      ->findOneBy([
                          'isActive' => 1
                      ]);
        
        if ($year) {
            $yearId = $year->getId();
        }
        
        return $yearId;
    }
    
    /**
     *
     * @return NULL|int
     */
    public function getActiveYear ()
    {
        $yearId = null;
        
        if($this->request) {
            // On verifie si une année scolaire a été choisie
            if ($this->request->getSession()->has('year') === true) {
                $yearId = $this->request->getSession()->get('year');
            } else {
                $year = $this->getEm()
                              ->getRepository(SchoolYear::class)
                              ->findOneBy([
                                  'isActive' => 1
                              ]);
                
                if ($year) {
                    $yearId = $year->getId();
                }
            }
        }
        else {
            $year = $this->getEm()
                          ->getRepository(SchoolYear::class)
                          ->findOneBy([
                              'isActive' => 1
                          ]);
            
            if ($year) {
                $yearId = $year->getId();
            }
        }
        
        
        
        return $yearId;
    }
    
    /**
     * @return null
     */
    public function getActiveYearLabel ()
    {
        $yearLabel = null;
        
        if($this->request) {
            // On verifie si une année scolaire a été choisie
            if ($this->request->getSession()->has('year') === true) {
                $yearId = $this->request->getSession()->get('year');
                $year =  $this->getEm()
                               ->getRepository(SchoolYear::class)
                               ->find($yearId);
                if ($year) {
                    $yearLabel = $year->getLabel();
                }
            } else {
                $year = $this->getEm()
                              ->getRepository(SchoolYear::class)
                              ->findOneBy([
                                  'isActive' => 1
                              ]);
                
                if ($year) {
                    $yearLabel = $year->getLabel();
                }
            }
        }
        else {
            $year = $this->getEm()
                          ->getRepository(SchoolYear::class)
                          ->findOneBy([
                              'isActive' => 1
                          ]);
            
            if ($year) {
                $yearLabel = $year->getLabel();
            }
        }
        
        
        
        return $yearLabel;
    }
}