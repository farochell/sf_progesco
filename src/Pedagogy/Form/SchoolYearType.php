<?php
/**
 * Created by PhpStorm.
 * User: Emile
 * Date: 20/11/2019
 */

namespace App\Pedagogy\Form;

use App\Pedagogy\Entity\SchoolYear;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AnneeScolaireType
 * @package App\Configuration\Form
 */
class SchoolYearType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, ['label' => 'Libellé', 'attr' => ['class' => 'form-control col-sm-3']])
            ->add(
                'startDate',
                DateType::class,
                [
                    'label'  => 'Date de début',
                    'widget' => 'single_text',
                    'html5'  => false,
                    'attr'   => ['class' => 'form-control col-sm-3 js-datepicker'],
                ]
            )
            ->add(
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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => SchoolYear::class,
                'id'         => null,
            ]
        );
    }
}
