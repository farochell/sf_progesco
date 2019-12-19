<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   11/12/2019
 * @time  :   15:10
 */

namespace App\Teacher\Listener;


use App\Teacher\Entity\Teacher;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class TeacherListener
 *
 * @package App\Teacher\Listener
 *
 */
class TeacherListener
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
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        
        $object = $args->getObject();
        
        if (!$object instanceof Teacher) {
            return;
        }
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $objectManager = $args->getObjectManager();
        $object->setIsActive(1);
        $objectManager->flush();
    }
    
    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        
        if (!$object instanceof Teacher) {
            return;
        }
        
        $matricule = 'PR-'.strtoupper(mb_convert_encoding(substr($object->getLastname(), 0, 3),'UTF-8')).''.strtoupper(mb_convert_encoding(substr
            ($object->getFirstname(), 0, 3),'UTF-8')).str_pad
            ($object->getId(), '5', '0');
        $object->setMatricule($matricule);
        $objectManager = $args->getObjectManager();
        $objectManager->flush();
    }
    
    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if (!$object instanceof Teacher) {
            return;
        }
        
    }
}