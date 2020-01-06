<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   30/12/2019
 * @time  :   20:24
 */

namespace App\Schooling\Form;


use App\Pedagogy\Entity\Grade;
use App\Pedagogy\Entity\Level;
use App\Pedagogy\Entity\SchoolYear;
use App\Pedagogy\Helper\SchoolYearHelper;
use App\Schooling\Entity\Registration;
use App\Student\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RegistrationType
 *
 * @package App\Schooling\Form
 *
 */
class RegistrationType extends AbstractType
{
    /**
     * @var SchoolYearHelper
     */
    private $schoolYearHelper;
    
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * TuitionType constructor.
     *
     * @param EntityManagerInterface $em
     * @param SchoolYearHelper       $schoolYearHelper
     */
    public function __construct(EntityManagerInterface $em, SchoolYearHelper $schoolYearHelper)
    {
        $this->entityManager    = $em;
        $this->schoolYearHelper = $schoolYearHelper;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'schoolYear',
            EntityType::class,
            [
                'label'         => 'Année scolaire',
                'class'         => SchoolYear::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')->where("u.id =".$this->schoolYearHelper->getActiveYear());
                },
                'choice_label'  => 'label',
                'attr'          => ['class' => 'form-control col-sm-12 col-md-4'],
            ]
        )->add(
            'student',
            EntityType::class,
            [
                'label'         => 'Etudiant',
                'class'         => Student::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')->where("u.id =".$options['student-id']);
                },
                'attr'          => ['class' => 'form-control col-sm-12 col-md-4'],
            ]
        )
                ->add(
                    'registrationDate',
                    DateType::class,
                    [
                        'label'       => 'Date d\'inscription',
                        'widget' => 'single_text',
                        'html5'  => false,
                        'attr'   => ['class' => 'form-control js-datepicker col-sm-12 col-md-4'],
                    ]
                )->add(
                'hasStateScholarship',
                ChoiceType::class,
                [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false,
                    ],
                    'label'   => 'Est boursier d\'état',
                    'attr'    => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            )
                ->add(
                    'level',
                    EntityType::class,
                    [
                        'placeholder' => 'Sélectionner...',
                        'mapped'      => false,
                        'label'       => 'Niveau',
                        'class'       => Level::class,
                        'attr'        => ['class' => 'form-control col-sm-12 col-md-4'],
                    ]
                );
        
        $formModifier = function (FormInterface $form, Level $level = null) {
            $grades = null === $level ? [] : $level->getGrades();
            
            $form->add(
                'grade',
                EntityType::class,
                [
                    'class'       => Grade::class,
                    'placeholder' => '',
                    'choices'     => $grades,
                    'label'       => 'Classe',
                    'attr'        => ['class' => 'form-control col-sm-12 col-md-4'],
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
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Registration::class,
                'id'         => null,
                'student-id' => null,
            ]
        );
    }
}