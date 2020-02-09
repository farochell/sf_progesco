<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/02/2020
 * @time  :   11:42
 */

namespace App\Scoring\Form;


use App\Pedagogy\Entity\Course;
use App\Pedagogy\Entity\Grade;
use App\Pedagogy\Entity\Semester;
use App\Pedagogy\Entity\Subject;
use App\Pedagogy\Helper\SchoolYearHelper;
use App\Scoring\Entity\ClassNote;
use App\Scoring\Entity\TypeOfRating;
use App\Teacher\Entity\Teacher;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ClassNoteType
 *
 * @package App\Scoring\Form
 *
 */
class ClassNoteType extends AbstractType {
    /**
     * @var SchoolYearHelper
     */
    private $schoolYearHelper;
    
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * ExpenseLineType constructor.
     *
     * @param EntityManagerInterface $em
     * @param SchoolYearHelper       $schoolYearHelper
     */
    public function __construct(EntityManagerInterface $em, SchoolYearHelper $schoolYearHelper) {
        $this->entityManager    = $em;
        $this->schoolYearHelper = $schoolYearHelper;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add(
                'typeOfRating',
                EntityType::class,
                [
                    'class' => TypeOfRating::class,
                    'label' => 'Type de devoir',
                    'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            )
            ->add(
                'semester',
                EntityType::class,
                [
                    'label'         => 'Période',
                    'class'         => Semester::class,
                    'query_builder' => function (EntityRepository $er) use ($options) {
                        return $er->createQueryBuilder('u')->where("u.schoolyear =".$this->schoolYearHelper->getActiveYear());
                    },
                    'choice_label'  => 'label',
                    'attr'          => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            )
            ->add(
                'label', TextType::class, [
                'label' => 'Libellé',
                'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
            ]
            )
            ->add(
                'grade',
                EntityType::class,
                [
                    'class' => Grade::class,
                    'label' => 'Classe',
                    'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            )
            ->add(
                'subject',
                EntityType::class,
                [
                    'class' => Subject::class,
                    'label' => 'Matière',
                    'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            )->add(
                'teacher',
                EntityType::class,
                [
                    'class' => Teacher::class,
                    'label' => 'Enseignant',
                    'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
            [
                'data_class' => ClassNote::class,
                'id'         => null,
            ]
        );
    }
}