<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   26/12/2019
 * @time  :   13:20
 */

namespace App\Accounting\Form;


use App\Accounting\Entity\Tuition;
use App\Pedagogy\Entity\Level;
use App\Pedagogy\Entity\SchoolYear;
use App\Pedagogy\Entity\Study;
use App\Pedagogy\Helper\SchoolYearHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TuitionType
 *
 * @package App\Accounting\Form
 *
 */
class TuitionType extends AbstractType
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
                'level',
                EntityType::class,
                [
                    'placeholder'  => 'Sélectionner...',
                    'label'        => 'Niveau',
                    'class'        => Level::class,
                    'choice_label' => 'label',
                    'attr'         => ['class' => 'form-control col-sm-12 col-md-4'],
                ]
            )
            ->add(
                'fees',
                MoneyType::class,
                [
                    'currency' => 'XOF',
                    'label'    => 'Montant',
                    'attr'     => [
                        'class' => 'form-control col-sm-12 col-md-4',
                    ],
                ]
            );
        
        $formModifier = function (FormInterface $form, Level $level = null) {
            $levelId  = null === $level ? [] : $level->getId();
            $tuitions = $this->entityManager->getRepository(Tuition::class)->findBy(
                [
                    'level'      => $levelId,
                    'schoolYear' =>
                        $this->schoolYearHelper->getActiveYear(),
                ]
            );
            
            $exclude = [];
            foreach ($tuitions as $tuition) {
                $studies = $tuition->getStudies();
                if ($studies) {
                    foreach ($studies as $study) {
                        $exclude[] = $study->getId();
                    }
                }
                
            }
            
            $form->add(
                'studies',
                EntityType::class,
                [
                    'class'         => Study::class,
                    'placeholder'   => '',
                    'multiple'      => true,
                    'query_builder' => function (EntityRepository $er) use ($exclude) {
                        if (!empty($exclude)) {
                            return $er->createQueryBuilder('u')->where("u.id not in (".implode(",", $exclude).")");
                        }
                        
                    },
                    'label'         => 'Filières',
                    'attr'          => ['class' => 'form-control col-sm-12 col-md-4'],
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
                'data_class' => Tuition::class,
                'id'         => null,
            ]
        );
    }
}