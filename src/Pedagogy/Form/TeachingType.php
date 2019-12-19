<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   22/11/2019
 * @time  :   17:11
 */

namespace App\Pedagogy\Form;


use App\Pedagogy\Entity\Speciality;
use App\Pedagogy\Entity\Teaching;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TeachingType
 *
 * @package App\Pedagogy\Form
 *
 */
class TeachingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, ['label' => 'Libellé', 'attr' => ['class' => 'form-control']])
            ->add('code', TextType::class, ['label' => 'Code', 'attr' => ['class' => 'form-control']])
            ->add(
                'speciality',
                EntityType::class,
                [
                    'label'        => 'Spécialité',
                    'placeholder' => '...',
                    'class'        => Speciality::class,
                    'choice_label' => 'label',
                    'attr'         => ['class' => 'form-control'],
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
                'data_class' => Teaching::class,
                'id'         => null,
            ]
        );
    }
}