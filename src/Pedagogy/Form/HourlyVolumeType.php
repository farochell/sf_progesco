<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   19/02/2020
 */

namespace App\Pedagogy\Form;


use App\Pedagogy\Entity\Grade;
use App\Pedagogy\Entity\HourlyVolume;
use App\Pedagogy\Entity\Semester;
use App\Pedagogy\Entity\Subject;
use App\Pedagogy\Helper\SchoolYearHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class HourlyVolumeType
 *
 * @package App\Pedagogy\Form
 *
 */
class HourlyVolumeType extends AbstractType {
    
    /**
     * @var SchoolYearHelper
     */
    private $schoolYearHelper;
    
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * @var TranslatorInterface
     */
    private $translator;
    
    /**
     * ExpenseLineType constructor.
     *
     * @param EntityManagerInterface $em
     * @param SchoolYearHelper       $schoolYearHelper
     * @param TranslatorInterface    $translator
     */
    public function __construct(EntityManagerInterface $em, SchoolYearHelper $schoolYearHelper, TranslatorInterface $translator) {
        $this->entityManager    = $em;
        $this->schoolYearHelper = $schoolYearHelper;
        $this->translator      = $translator;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'subject', EntityType::class, [
            'class' => Subject::class,
            'label' => $this->translator->trans('Matière'),
            'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
        ]
        );
        
        if ($options['grade_id'] != null) {
            $builder->add('grade', EntityType::class, [
                'label' => $this->translator->trans('Classe'),
                'class'         => Grade::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')->where("u.id =". $options["grade_id"]);
                },
                'choice_label'  => 'label',
                'attr'          => ['class' => 'form-control col-sm-12 col-md-4'],
            ]);
        } else {
            $builder->add('grade', EntityType::class, [
                'label' => $this->translator->trans('Classe'),
                'class' => Grade::class,
                'attr' => ['class' => 'form-control col-sm-12 col-md-4']
            ]);
        }
        
        $builder->add(
            'semester',
            EntityType::class,
            [
                'label'         => $this->translator->trans('Période'),
                'class'         => Semester::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')->where("u.schoolyear =".$this->schoolYearHelper->getActiveYear());
                },
                'choice_label'  => 'label',
                'attr'          => ['class' => 'form-control col-sm-12 col-md-4'],
            ]
        )->add('totalHours', NumberType::class,
            [
                'label' => $this->translator->trans('Nombre à effectuer'),
                'attr'  => ['class' => 'form-control col-sm-12 col-md-4']
            ]
        )->add('hoursTaught', NumberType::class,
            [
                'label' => $this->translator->trans('Heures effectuées'),
                'attr'  => ['class' => 'form-control col-sm-12 col-md-4']
            ]
        );
        
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
            [
                'data_class' => HourlyVolume::class,
                'id'         => null,
                'grade_id'   => null,
            ]
        );
    }
}