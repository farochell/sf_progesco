<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   21/11/2019
 * @time  :   14:17
 */

namespace App\Pedagogy\Form;

use App\Pedagogy\Entity\CoursePeriod;
use App\Pedagogy\Entity\Grade;
use App\Pedagogy\Entity\Group;
use App\Pedagogy\Entity\Level;
use App\Pedagogy\Entity\SchoolYear;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GroupType
 *
 * @package App\Pedagogy\Form
 *
 */
class GroupType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label', TextType::class, ['label' => 'Libellé', 'attr' => ['class' => 'form-control'],])
                ->add(
                    'schoolyear',
                    EntityType::class,
                    [
                        'label'        => 'Année scolaire',
                        'class'        => SchoolYear::class,
                        'choice_label' => 'label',
                        'attr'         => ['class' => 'form-control'],
                    ]
                )->add(
                'coursePeriod',
                EntityType::class,
                [
                    'label' => 'Type de vacation',
                    'class' => CoursePeriod::class,
                    'attr'  => ['class' => 'form-control'],
                ]
            )
                ->add('effective', NumberType::class, ['label' => 'Capacité d\'accueil', 'attr' => ['class' => 'form-control'],]);
        if ($options['level_id'] != null) {
            
            $builder->add(
                'level',
                EntityType::class,
                [
                    'class'         => Level::class,
                    'label'         => 'Niveau',
                    'attr'          => ['class' => 'form-control'],
                    'query_builder' => function (EntityRepository $er) use ($options) {
                        $id = $options['level_id'];
                        
                        return $er->createQueryBuilder('u')
                                  ->where('u.id = ?1')
                                  ->setParameter(1, $id);
                    },
                ]
            );
        } else {
            $builder->add(
                'level',
                EntityType::class,
                [
                    'class' => Level::class,
                    'label' => 'Niveau',
                    'attr'  => ['class' => 'form-control'],
                ]
            );
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Group::class,
                'id'         => null,
                'level_id'   => null,
            ]
        );
    }
}