<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/02/2020
 * @time  :   11:32
 */

namespace App\Scoring\Form;


use App\Scoring\Entity\TypeOfRating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TypeOfRatingType
 *
 * @package App\Scoring\Form
 *
 */
class TypeOfRatingType extends AbstractType {
    
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('label', TextType::class, [
            'label' => 'Libellé',
            'attr' => ['class' => 'form-control col-sm-12 col-md-4']
        ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => TypeOfRating::class,
                'id'         => null,
            ]
        );
    }
    
}