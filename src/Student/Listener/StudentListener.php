<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   27/12/2019
 * @time  :   18:26
 */

namespace App\Student\Listener;


use App\Student\Entity\Student;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class StudentListener
 *
 * @package App\Student\Listener
 *
 */
class StudentListener
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
        
        if (!$object instanceof Student) {
            return;
        }
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $objectManager = $args->getObjectManager();
        $object->setCreated(new \DateTime('now'));
        $object->setUpdated(new \DateTime('now'));
        $object->setUserCreation($user);
        $object->setIsActive(1);
        $objectManager->flush();
    }
    
    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        
        if (!$object instanceof Student) {
            return;
        }
        
        $date      = $object->getBirthDate();
        $date      = $date->format('Ymd');
        $matricule = 'ET-'.strtoupper(mb_convert_encoding(substr($object->getLastname(), 0, 2), 'UTF-8')).''.strtoupper(
                mb_convert_encoding(
                    substr
                    (
                        $object->getFirstname(),
                        0,
                        2
                    ),
                    'UTF-8'
                )
            ).$date.'-'.$object->getId();
        $object->setMatricule($matricule);
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
        
        
        if (!$object instanceof Student) {
            return;
        }
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $object->setUserModification($user);
        $object->setUpdated(new \DateTime('now'));
        $date      = $object->getBirthDate();
        $date      = $date->format('Ymd');
        $matricule = 'ET-'.strtoupper(mb_convert_encoding(substr($object->getLastname(), 0, 2), 'UTF-8')).''.strtoupper(
                mb_convert_encoding(substr($object->getFirstname(), 0, 2), 'UTF-8')
            ).$date.'-'.$object->getId();
        $object->setMatricule($matricule);
    }
}