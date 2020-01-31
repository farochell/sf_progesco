<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   18:28
 */

namespace App\Accounting\Form;


use App\Accounting\Entity\Cheque;
use App\Accounting\Entity\PaymentPlan;
use App\Accounting\Entity\ScholarshipPaymentPlan;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ChequeType
 *
 * @package App\Accounting\Form
 *
 */
class ChequeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(isset($options['paymentplan_id'])) {
            $builder
                ->add(
                    'paymentPlan',
                    EntityType::class,
                    [
                        'class'         => PaymentPlan::class,
                        'query_builder' => function (EntityRepository $er) use ($options) {
                            return $er->createQueryBuilder('u')
                                      ->where("u.id =".$options['paymentplan_id']);
                        },
                        'label' => 'Plan de paiement',
                        'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                    ]
                );
        }
    
        if(isset($options['scholarshippaymentplan_id'])) {
            $builder
                ->add(
                    'scholarshipPaymentPlan',
                    EntityType::class,
                    [
                        'class'         => ScholarshipPaymentPlan::class,
                        'query_builder' => function (EntityRepository $er) use ($options) {
                            return $er->createQueryBuilder('u')
                                      ->where("u.id =".$options['scholarshippaymentplan_id']);
                        },
                        'label' => 'Plan de paiement',
                        'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                    ]
                );
        }
        
            $builder->add(
                'holder',
                TextType::class,
                [
                    'label' => 'Titulaire',
                    'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            )->add(
                'number',
                TextType::class,
                [
                    'label' => 'Numéro de chèque',
                    'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            )->add(
                'bank',
                TextType::class,
                [
                    'label' => 'Banque',
                    'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cheque::class,
            'id' => null,
            'paymentplan_id' => null,
            'scholarshippaymentplan_id' => null,
        ]);
    }
}