<?php
/**
 * PRIVATE
 *
 * emile.camara
 * 16/11/2019
 */

namespace App\Pedagogy\Form;


use App\Pedagogy\Entity\Level;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LevelType
 *
 * @package App\Pedagogy\Form
 *
 */
class LevelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label', TextType::class, ['label' => 'Libellé', 'attr' => ['class' => 'form-control']]);
        $builder->add('order', NumberType::class, ['label' => 'Ordre', 'attr' => ['class' => 'form-control']]);
        $builder->add('step', TextType::class, ['label' => 'Autre libellé', 'attr' => ['class' => 'form-control']]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Level::class,
                'id'         => null,
            ]
        );
    }
}