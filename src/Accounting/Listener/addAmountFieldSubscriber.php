<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   15:47
 */

namespace App\Accounting\Listener;


use App\Accounting\Entity\Payment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class addAmountFieldSubscriber
 *
 * @package App\Accounting\Listener
 *
 */
class addAmountFieldSubscriber implements EventSubscriberInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;
    /**
     * @var
     */
    private $em;
    
    /**
     * @param FormFactoryInterface $factory
     * @param $em
     */
    public function __construct(FormFactoryInterface $factory, EntityManagerInterface $em)
    {
        $this->factory = $factory;
        $this->em = $em;
    }
    
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return [FormEvents::POST_SET_DATA => 'preSetData'];
    }
    
    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $payementplan = $event->getData();
        $form = $event->getForm();
        $attributes = $form->getConfig()->getOptions();
        $id = $attributes['id'];
    
        if (!$payementplan || NULL === $payementplan->getId()) {
            $payment = $this->em->getRepository(Payment::class)->find($id);
            $totalAmount = $payment->getTuition() - $payment->getReduction();
    
            $amountPaid = 0;
            $paymentplans = $payment->getPaymentPlans();
            if(isset($paymentplans) && null !== $paymentplans ) {
                foreach($paymentplans as $paymentplan){
                    $amountPaid = $amountPaid + $paymentplan->getAmount();
                }
            }
    
            $leftToPay = $totalAmount - $amountPaid;
            $form->add('amount', TextType::class, [
                'data' => $leftToPay,
                'label'    => 'Montant',
                'attr'     => [
                    'class' => 'form-control col-sm-12 col-md-4',
                ],
            ]);
        }
    }
}