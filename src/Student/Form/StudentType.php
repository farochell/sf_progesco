<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   26/12/2019
 * @time  :   17:56
 */

namespace App\Student\Form;


use App\Configuration\Entity\Gender;
use App\Configuration\Entity\MaritalStatus;
use App\Student\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class StudentType
 *
 * @package App\Student\Form
 *
 */
class StudentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'gender',
            EntityType::class,
            [
                'placeholder' => 'Sélectionner...',
                'label'       => 'Genre',
                'class'       => Gender::class,
                'attr'        => ['class' => 'form-control col-sm-12'],
            ]
        )
                ->add('nbChild', NumberType::class, ['label' => 'Nombre d\'enfant(s)', 'attr' => ['class' => 'form-control col-sm-12']])
                ->add(
                    'maritalStatus',
                    EntityType::class,
                    [
                        'placeholder' => 'Sélectionner...',
                        'label'       => 'Situation matrimoniale',
                        'class'       => MaritalStatus::class,
                        'attr'        => ['class' => 'form-control col-sm-12'],
                    ]
                )
                ->add('firstname', TextType::class, ['label' => 'Prénom', 'attr' => ['class' => 'form-control col-sm-12']])
                ->add('lastname', TextType::class, ['label' => 'Nom', 'attr' => ['class' => 'form-control col-sm-12']])
                ->add(
                    'registrationDate',
                    DateType::class,
                    [
                        'label'  => 'Date d\'inscription',
                        'widget' => 'single_text',
                        'html5'  => false,
                        'attr'   => ['class' => 'form-control js-datepicker col-sm-12'],
                    ]
                )
                ->add(
                    'birthDate',
                    DateType::class,
                    [
                        'label'  => 'Date de naissance',
                        'widget' => 'single_text',
                        'html5'  => false,
                        'attr'   => ['class' => 'form-control js-datepicker col-sm-12'],
                    ]
                )->add(
                'birthPlace',
                TextType::class,
                [
                    'label' => 'Lieu de naissance',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Email',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )->add(
                'phone',
                EmailType::class,
                [
                    'label' => 'Téléphone',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )->add(
                'address',
                TextareaType::class,
                [
                    'label' => 'Adresse',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )->add(
                'fatherLastname',
                TextType::class,
                [
                    'label' => 'Nom du père',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )
                ->add(
                    'fatherFirstname',
                    TextType::class,
                    [
                        'label' => 'Prénom du père',
                        'attr'  => ['class' => 'form-control col-sm-12'],
                    ]
                )
                ->add(
                    'fatherLastname',
                    TextType::class,
                    [
                        'label' => 'Nom du père',
                        'attr'  => ['class' => 'form-control col-sm-12'],
                    ]
                )
                ->add(
                    'fatherFirstname',
                    TextType::class,
                    [
                        'label' => 'Prénom du père',
                        'attr'  => ['class' => 'form-control col-sm-12'],
                    ]
                )
                ->add(
                    'fatherProfession',
                    TextType::class,
                    [
                        'label' => 'Profession du père',
                        'attr'  => ['class' => 'form-control col-sm-12'],
                    ]
                )
            ->add(
                'motherLastname',
                TextType::class,
                [
                    'label' => 'Nom de la mère',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )
            ->add(
                'motherFirstname',
                TextType::class,
                [
                    'label' => 'Prénom de la mère',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )
            ->add(
                'motherProfession',
                TextType::class,
                [
                    'label' => 'Profession de la mère',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )->add(
                'guardianLastname',
                TextType::class,
                [
                    'label' => 'Nom du tuteur',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )
            ->add(
                'guardianFirstname',
                TextType::class,
                [
                    'label' => 'Prénom du tuteur',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )
            ->add(
                'guardianProfession',
                TextType::class,
                [
                    'label' => 'Profession du tuteur',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )
            ->add(
                'guardianPhone1',
                TextType::class,
                [
                    'label' => 'Téléphone 1 du tuteur',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )
            ->add(
                'guardianPhone2',
                TextType::class,
                [
                    'label' => 'Téléphone 2 du tuteur',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )
            ->add(
                'guardianAddress',
                TextareaType::class,
                [
                    'label' => 'Adresse du tuteur',
                    'attr'  => ['class' => 'form-control col-sm-12'],
                ]
            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Student::class,
                'id'         => null,
            ]
        );
    }
}