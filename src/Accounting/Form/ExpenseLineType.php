<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   15/01/2020
 * @time  :   14:47
 */

namespace App\Accounting\Form;

use App\Accounting\Entity\ExpenseLine;
use App\Accounting\Entity\ExpenseType;
use App\Pedagogy\Entity\SchoolYear;
use App\Pedagogy\Helper\SchoolYearHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ExpenseLineType
 *
 * @package App\Accounting\Form
 *
 */
class ExpenseLineType extends AbstractType
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
     * ExpenseLineType constructor.
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
        $builder
            ->add(
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
            )
            ->add(
                'expenseDate',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'html5'  => false,
                    'label'  => 'Date de la dépense',
                    'attr'   => ['class' => 'form-control col-sm-12 col-md-4 js-datepicker'],
                ]
            )->add(
                'expenseType',
                EntityType::class,
                [
                    'class' => ExpenseType::class,
                    'label'  => 'Type de dépense',
                    'attr'   => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            )
            ->add(
                'amount',
                MoneyType::class,
                [
                    'label'    => 'Montant',
                    'currency' => 'XOF',
                    'attr'     => ['class' => 'form-control col-sm-12 col-md-2'],
                ]
            )
            ->add(
                'comment',
                TextareaType::class,
                [
                    'label' => 'Commentaire',
                    'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
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
                'data_class' => ExpenseLine::class,
                'id'         => null,
            ]
        );
    }
}