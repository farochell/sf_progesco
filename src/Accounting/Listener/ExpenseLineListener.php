<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   15/01/2020
 * @time  :   13:56
 */

namespace App\Accounting\Listener;


use App\Accounting\Entity\ExpenseLine;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ExpenseLineListener
 *
 * @package App\Accounting\Listener
 *
 */
class ExpenseLineListener
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
        
        if (!$object instanceof ExpenseLine) {
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
        $object = $args->getObject();
        
        if (!$object instanceof ExpenseLine) {
            return;
        }
        $reference = 'DP'.str_pad($object->getId(), 10, "0", STR_PAD_LEFT);
        $object->setReference($reference);
        $objectManager = $args->getObjectManager();
        $objectManager->flush();
    }
    
    /**
     * @param LifecycleEventArgs $args
     *
     * @throws \Exception
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        
        if (!$object instanceof ExpenseLine) {
            return;
        }
        $object->setUpdated(new \DateTime('now'));
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $object->setUserModification($user);
        
    }
}