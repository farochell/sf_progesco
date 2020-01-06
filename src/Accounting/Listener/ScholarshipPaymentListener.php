<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   12:22
 */

namespace App\Accounting\Listener;


use App\Accounting\Entity\ScholarshipPayment;
use App\Schooling\Entity\Registration;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ScholarshipPaymentListener
 *
 * @package App\Accounting\Listener
 *
 */
class ScholarshipPaymentListener
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
        
        if (!$object instanceof ScholarshipPayment) {
            return;
        }
        $user          = $this->container->get('security.token_storage')->getToken()->getUser();
        $objectManager = $args->getObjectManager();
        
        $object->setBalance($object->getTuition());
        
        $object->setUserCreation($user);
        $object->setCreated(new \DateTime('now'));
        $object->setUpdated(new \DateTime('now'));
        $objectManager->flush();
        
        // MAJ de l'inscription
        $registrationId = $object->getRegistration();
        $inscription = $objectManager->getRepository(Registration::class)->find($registrationId);
        $inscription->setStatus(Registration::VALIDED);
        $objectManager->flush();
    }
    
    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        
        $object = $args->getObject();
        
        if (!$object instanceof ScholarshipPayment) {
            return;
        }
        
        $objectManager = $args->getObjectManager();
        $reference = 'PAB'.date('mdY').'-'.$object->getId();
        $object->setReference($reference);
        
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
        
        if (!$object instanceof ScholarshipPayment) {
            return;
        }
        $object->setUpdated(new \DateTime('now'));
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $object->setUserModification($user);
        
    }
}