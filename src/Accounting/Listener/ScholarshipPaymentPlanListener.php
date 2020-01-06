<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   14:36
 */

namespace App\Accounting\Listener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ScholarshipPaymentPlanListener
 *
 * @package App\Accounting\Listener
 *
 */
class ScholarshipPaymentPlanListener
{
    /**
     * @var ContainerInterface
     */
    private $container;
    
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /**
     * @param LifecycleEventArgs $args
     *
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        
        if (!$object instanceof ScholarshipPaymentPlan) {
            return;
        }
        $user          = $this->container->get('security.token_storage')->getToken()->getUser();
        $objectManager = $args->getObjectManager();
        
        $object->setUserCreation($user);
        $object->setCreated(new \DateTime('now'));
        $object->setUpdated(new \DateTime('now'));
        $objectManager->flush();
        
    }
    
    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
    
    }
    
    /**
     * @param LifecycleEventArgs $args
     *
     * @throws \Exception
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        
        $object = $args->getObject();
        
        if (!$object instanceof ScholarshipPaymentPlan) {
            return;
        }
        $object->setUpdated(new \DateTime('now'));
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $object->setUserModification($user);
        
    }
}