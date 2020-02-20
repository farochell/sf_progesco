<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   05/01/2020
 * @time  :   15:54
 */

namespace App\Accounting\Listener;


use App\Accounting\Entity\Cheque;
use App\Accounting\Entity\PaymentPlan;
use App\Accounting\Entity\ScholarshipPaymentPlan;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ChequeListener {
    /**
     * @var ContainerInterface
     */
    private $container;
    
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    
    /**
     * @param LifecycleEventArgs $args
     *
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $args) {
        $object        = $args->getObject();
        $objectManager = $args->getObjectManager();
        if (!$object instanceof Cheque) {
            return;
        }
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $object->setUserCreation($user);
        if ($object->getPaymentPlan() != null) {
            $object->setAmount($object->getPaymentPlan()->getAmount());
        } else {
            $object->setAmount($object->getScholarshipPaymentPlan()->getAmount());
        }
        
        $object->setCreated(new \DateTime('now'));
        $object->setUpdated(new \DateTime('now'));
        $objectManager->flush();
        if ($object->getPaymentPlan() != null) {
            $paymentPlan = $object->getPaymentPlan();
            $paymentPlan->setStatus(PaymentPlan::PAYMENT_CHQ_W);
        } else {
            $paymentPlan = $object->getScholarshipPaymentPlan();
            $paymentPlan->setStatus(ScholarshipPaymentPlan::PAYMENT_CHQ_W);
        }
        $objectManager->flush();
    }
}