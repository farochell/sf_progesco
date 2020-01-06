<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   02/01/2020
 * @time  :   16:04
 */

namespace App\Accounting\Listener;

use App\Accounting\Entity\Payment;
use App\Schooling\Entity\Registration;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PaymentListener
 *
 * @package App\Accounting\Listener
 *
 */
class PaymentListener
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
        $objectManager = $args->getObjectManager();
        if (!$object instanceof Payment) {
            return;
        }
        $user          = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $leftToPay     = $object->getTuition() - $object->getReduction();
        
        $object->setBalance($leftToPay);
    
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
        
        if (!$object instanceof Payment) {
            return;
        }
        
        $objectManager = $args->getObjectManager();
        $reference = 'PA'.date('mdY').'-'.$object->getId();
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
        
        if (!$object instanceof Payment) {
            return;
        }
        $object->setUpdated(new \DateTime('now'));
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $object->setUserModification($user);
        
    }
}