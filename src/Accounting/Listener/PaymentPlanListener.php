<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   14:33
 */

namespace App\Accounting\Listener;

use App\Accounting\Entity\Payment;
use App\Accounting\Entity\PaymentPlan;
use App\Payement\Entity\PlanPayement;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PaymentPlanListener
 *
 * @package App\Accounting\Listener
 *
 */
class PaymentPlanListener
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
        
        if (!$object instanceof PaymentPlan) {
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
    
        if (!$object instanceof PaymentPlan) {
            return;
        }
        $reference = 'PPnB'.str_pad($object->getId(), 10, "0", STR_PAD_LEFT);
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
        
        if (!$object instanceof PaymentPlan) {
            return;
        }
        $object->setUpdated(new \DateTime('now'));
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $object->setUserModification($user);
        
    }
    
    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args) {
        $object = $args->getObject();
    
        if (!$object instanceof PaymentPlan) {
            return;
        }
        $status = $object->getStatus();
        if($status == PaymentPlan::PAYMENT_BANK_TFT_V || $status == PaymentPlan::PAYMENT_CHQ_V || $status == PaymentPlan::PAYMENT_CASH) {
            $amount = $object->getAmount();
            $payment = $object->getPayment();
            $balance = $payment->getBalance() + $amount;
            $payment->setBalance($balance);
            $payment->setStatus(Payment::ACTIVE);
            $objectManager = $args->getObjectManager();
            $objectManager->flush();
        }
    }
}