<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   30/12/2019
 * @time  :   20:09
 */

namespace App\Schooling\Listener;


use App\Schooling\Entity\Registration;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RegistrationListener
 *
 * @package App\Schooling\Listener
 *
 */
class RegistrationListener
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
        
        if (!$object instanceof Registration) {
            return;
        }
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $objectManager = $args->getObjectManager();
        $object->setCreated(new \DateTime('now'));
        $object->setUpdated(new \DateTime('now'));
        $object->setUserCreation($user);
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
        
        
        if (!$object instanceof Registration) {
            return;
        }
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $object->setUserModification($user);
        $object->setUpdated(new \DateTime('now'));
    }
}