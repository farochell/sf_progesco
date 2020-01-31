<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   12/01/2020
 * @time  :   14:09
 */

namespace App\Accounting\Form;


use App\Accounting\Entity\ScholarshipPayment;
use App\Accounting\Entity\ScholarshipPaymentPlan;
use App\Accounting\Listener\AddScholarshipAmountFieldSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScholarshipPaymentPlanType extends AbstractType
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
        $subscriber = new AddScholarshipAmountFieldSubscriber($builder->getFormFactory(), $this->entityManager);
        $builder
            ->add(
                'scholarshipPayment',
                EntityType::class,
                [
                    'class'         => ScholarshipPayment::class,
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
            'data_class' => ScholarshipPaymentPlan::class,
            'id' => null,
        ]);
    }
}