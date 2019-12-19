<?php
/**
 * Created by PhpStorm.
 * User: Emile
 * Date: 11/02/2018
 * Time: 11:32
 */

namespace App\Pedagogy\Form;

use App\Pedagogy\Entity\Grade;
use App\Pedagogy\Entity\Level;
use App\Pedagogy\Entity\Study;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ClassroomType
 * @package App\Pedagogy\Form
 */
class GradeType extends AbstractType
{
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label', TextType::class, ['label' => 'Libellé', 'attr' => ['class' => 'form-control']])
                ->add(
                    'level',
                    EntityType::class,
                    [
                        'class' => Level::class,
                        'label' => 'Niveau',
                        'attr'  => ['class' => 'form-control'],
                    ]
                )->add(
                'study',
                EntityType::class,
                [
                    'class' => Study::class,
                    'label' => 'Filière',
                    'attr'  => ['class' => 'form-control'],
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
                'data_class' => Grade::class,
                'id'         => null,
            
            ]
        );
    }
    
}