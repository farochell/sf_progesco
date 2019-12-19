<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   28/11/2019
 * @time  :   15:06
 */

namespace App\Pedagogy\Form;


use App\Classroom\Entity\Classroom;
use App\Pedagogy\Entity\Course;
use App\Pedagogy\Entity\Group;
use App\Pedagogy\Entity\Level;
use App\Pedagogy\Entity\Semester;
use App\Pedagogy\Entity\Teaching;
use App\Teacher\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CourseType
 *
 * @package App\Pedagogy\Form
 * @TODO Récupération par année scolaire (Semestres, groupes)
 */
class CourseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'teaching',
            EntityType::class,
            [
                'label'        => 'Matière',
                'class'        => Teaching::class,
                'choice_label' => 'label',
                'attr'         => ['class' => 'form-control col-sm-12'],
            ]
        )->add(
            'teacher',
            EntityType::class,
            [
                'label'        => 'Professeur',
                'class'        => Teacher::class,
                'attr'         => ['class' => 'form-control col-sm-12'],
            ]
        )->add(
            'semester',
            EntityType::class,
            [
                'label'        => 'Période',
                'class'        => Semester::class,
                'choice_label' => 'label',
                'attr'         => ['class' => 'form-control col-sm-12'],
            ]
        )->add(
            'courseDate',
            DateType::class,
            [
                'label'  => 'Date du cours',
                'widget' => 'single_text',
                'html5'  => false,
                'attr'   => ['class' => 'form-control js-datepicker col-sm-12'],
            ]
        )->add(
            'startHour',
            TimeType::class,
            [
                'label'                     => 'Heure de début',
                'choice_translation_domain' => false,
                'input'                     => 'datetime',
                'html5'                     => false,
                'widget'                    => 'choice',
                'attr'                      => ['class' => ''],
            ]
        )->add(
            'endHour',
            TimeType::class,
            [
                'label'  => 'Heure de fin',
                'input'  => 'datetime',
                'html5'  => false,
                'widget' => 'choice',
                'attr'   => ['class' => ''],
            ]
        )->add(
            'classroom',
            EntityType::class,
            [
                'label'        => 'Salle de classe',
                'class'        => Classroom::class,
                'choice_label' => 'label',
                'attr'         => ['class' => 'form-control col-sm-12'],
            ]
        )->add(
            'level',
            EntityType::class,
            [
                'placeholder'  => 'Sélectionner...',
                'mapped'       => false,
                'label'        => 'Niveau',
                'class'        => Level::class,
                'attr'         => ['class' => 'form-control col-sm-12'],
            ]
        );
        
        $formModifier = function (FormInterface $form, Level $level = null) {
            $groups = null === $level ? [] : $level->getGroups();
            
            $form->add(
                'groups',
                EntityType::class,
                [
                    'class'       => Group::class,
                    'placeholder' => '',
                    'multiple'    => true,
                    'choices'     => $groups,
                    'attr'         => ['class' => 'form-control col-sm-12'],
                ]
            );
        };
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                
                $formModifier($event->getForm(), $data->getLevel());
            }
        );
        
        $builder->get('level')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $level = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $level);
            }
        );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Course::class,
                'id'         => null,
            ]
        );
    }
}