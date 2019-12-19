<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   27/11/2019
 * @time  :   21:58
 */

namespace App\Pedagogy\Form;


use App\Pedagogy\Entity\Level;
use App\Pedagogy\Entity\SchoolYear;
use App\Pedagogy\Entity\Semester;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SemesterType
 *
 * @package App\Pedagogy\Form
 *
 */
class SemesterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label', TextType::class, ['label' => 'Libellé', 'attr' => ['class' => 'form-control']])
                ->add(
                    'schoolyear',
                    EntityType::class,
                    [
                        'label'        => 'Libellé',
                        'class'        => SchoolYear::class,
                        'choice_label' => 'label',
                        'attr'         => ['class' => 'form-control'],
                    ]
                )
                ->add(
                    'level',
                    EntityType::class,
                    [
                        'label'        => 'Niveau',
                        'class'        => Level::class,
                        'choice_label' => 'label',
                        'attr'         => ['class' => 'form-control'],
                    ]
                )->add(
                'startDate',
                DateType::class,
                [
                    'label'  => 'Date de début',
                    'widget' => 'single_text',
                    'html5'  => false,
                    'attr'   => ['class' => 'form-control col-sm-3 js-datepicker'],
                ]
            )->add(
                'endDate',
                DateType::class,
                [
                    'label'  => 'Date de fin',
                    'widget' => 'single_text',
                    'html5'  => false,
                    'attr'   => ['class' => 'form-control col-sm-3 js-datepicker'],
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
                'data_class' => Semester::class,
                'id'         => null,
            ]
        );
    }
}