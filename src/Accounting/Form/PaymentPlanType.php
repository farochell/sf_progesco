<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   15:45
 */

namespace App\Accounting\Form;


use App\Accounting\Entity\Payment;
use App\Accounting\Entity\PaymentPlan;
use App\Accounting\Listener\addAmountFieldSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PaymentPlanType
 *
 * @package App\Accounting\Form
 *
 */
class PaymentPlanType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscriber = new addAmountFieldSubscriber($builder->getFormFactory(), $this->entityManager);
        $builder
            ->add(
                'payment',
                EntityType::class,
                [
                    'class'         => Payment::class,
                    'query_builder' => function (EntityRepository $er) use ($options) {
                        return $er->createQueryBuilder('u')
                                  ->where("u.id =".$options['id']);
                    },
                    'label' => 'Paiement',
                    'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            )
            ->add(
            'label',
            TextType::class,
            [
                'label' => 'Libellé',
                'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
            ]
        )
                ->add(
                    'registrationDate',
                    DateType::class,
                    [
                        'widget' => 'single_text',
                        'html5'  => false,
                        'data'   => new \DateTime('now'),
                        'label'  => 'Date d\'enregistrement',
                        'attr'   => ['class' => 'form-control col-sm-12 col-md-4', 'readonly' => true],
                    ]
                )
                ->add(
                    'dateOfCollection',
                    DateType::class,
                    [
                        'widget' => 'single_text',
                        'html5'  => false,
                        'data'   => new \DateTime('now'),
                        'label'  => 'Date d\'encaissement',
                        'attr'   => ['class' => 'form-control js-datepicker col-sm-12 col-md-4'],
                    ]
                )
                ->add(
                    'comment',
                    TextareaType::class,
                    [
                        'label' => 'Commentaire',
                        'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                    ]
                )
               ;
        
        $builder->addEventSubscriber($subscriber);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PaymentPlan::class,
            'id' => null,
        ]);
    }
}