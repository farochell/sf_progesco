<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   11/12/2019
 * @time  :   15:01
 */

namespace App\Teacher\Form;


use App\Pedagogy\Entity\Speciality;
use App\Pedagogy\Form\SpecialityType;
use App\Teacher\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TeacherType
 *
 * @package App\Teacher\Form
 *
 */
class TeacherType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'firstname',
            TextType::class,
            [
                'label' => 'Prénom',
                'attr'  =>
                    [
                        'class' => 'form-control col-sm-12 col-md-4',
                    ],
            ]
        )
                ->add(
                    'lastname',
                    TextType::class,
                    [
                        'label' => 'Nom',
                        'attr'  =>
                            [
                                'class' => 'form-control col-sm-12 col-md-4',
                            ],
                    ]
                )
                ->add(
                    'birthDate',
                    DateType::class,
                    [
                        'label'  => 'Date de naissance',
                        'widget' => 'single_text',
                        'html5'  => false,
                        'attr'   => ['class' => 'form-control js-datepicker col-sm-12 col-md-4'],
                    ]
                )
                ->add(
                    'nationality',
                    TextType::class,
                    [
                        'label' => 'Nationalité',
                        'attr'  =>
                            [
                                'class' => 'form-control col-sm-12 col-md-4',
                            ],
                    ]
                )
                ->add(
                    'studyLevel',
                    TextType::class,
                    [
                        'label' => 'Niveau d\'étude',
                        'attr'  =>
                            [
                                'class' => 'form-control col-sm-12 col-md-4',
                            ],
                    ]
                )
                ->add(
                    'phone1',
                    TextType::class,
                    [
                        'label' => 'Téléphone 1',
                        'attr'  =>
                            [
                                'class' => 'form-control col-sm-12 col-md-4',
                            ],
                    ]
                )
                ->add(
                    'phone2',
                    TextType::class,
                    [
                        'label' => 'Téléphone 2',
                        'attr'  =>
                            [
                                'class' => 'form-control col-sm-12 col-md-4',
                            ],
                    ]
                )
                ->add(
                    'email',
                    TextType::class,
                    [
                        'label' => 'Adresse Email',
                        'attr'  =>
                            [
                                'class' => 'form-control col-sm-12 col-md-4',
                            ],
                    ]
                )
                ->add(
                    'address',
                    TextareaType::class,
                    [
                        'label' => 'Adresse',
                        'attr'  =>
                            [
                                'class' => 'form-control col-sm-12 col-md-4',
                            ],
                    ]
                )
                ->add(
                    'city',
                    TextType::class,
                    [
                        'label' => 'Ville',
                        'attr'  =>
                            [
                                'class' => 'form-control col-sm-12 col-md-4',
                            ],
                    ]
                )->add(
                'specialities',
                EntityType::class,
                [
                    'label'        => 'Spécialité',
                    'class'        => Speciality::class,
                    'choice_label' => 'label',
                    'multiple' => true,
                    'attr'         => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Teacher::class,
                'id'         => null,
            ]
        );
    }
}