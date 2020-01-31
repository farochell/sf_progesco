<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   14:36
 */

namespace App\Accounting\Listener;


use App\Accounting\Entity\ScholarshipPayment;
use App\Accounting\Entity\ScholarshipPaymentPlan;
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
        $object = $args->getObject();
        
        if (!$object instanceof ScholarshipPaymentPlan) {
            return;
        }
        $reference = 'PPB'.str_pad($object->getId(), 10, "0", STR_PAD_LEFT);
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
        
        if (!$object instanceof ScholarshipPaymentPlan) {
            return;
        }
        $object->setUpdated(new \DateTime('now'));
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $object->setUserModification($user);
        
    }
    
    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        
        if (!$object instanceof ScholarshipPaymentPlan) {
            return;
        }
        $status = $object->getStatus();
        if ($status == ScholarshipPaymentPlan::PAYMENT_BANK_TFT_V
            || $status == ScholarshipPaymentPlan::PAYMENT_CHQ_V
            || $status == ScholarshipPaymentPlan::PAYMENT_CASH) {
            $amount  = $object->getAmount();
            $payment = $object->getScholarshipPayment();
            $balance = $payment->getBalance() + $amount;
            $payment->setBalance($balance);
            $payment->setStatus(ScholarshipPayment::ACTIVE);
            $objectManager = $args->getObjectManager();
            $objectManager->flush();
        }
    }
}