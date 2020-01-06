<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   12:12
 */

namespace App\Accounting\Form;


use App\Accounting\Entity\ScholarshipPayment;
use App\Accounting\Listener\AddFeesFieldScholarshipSubscriber;
use App\Pedagogy\Helper\SchoolYearHelper;
use App\Schooling\Entity\Registration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class ScholarshipPaymentType
 *
 * @package App\Accounting\Form
 *
 */
class ScholarshipPaymentType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;
    
    /**
     * @var $anneeScolaireModel
     */
    private $schoolYearHelper;
    
    /**
     * @param EntityManagerInterface $em
     * @param AuthorizationChecker   $authorizationChecker
     * @param SchoolYearHelper       $schoolYearHelper
     */
    public function __construct(EntityManagerInterface $em, AuthorizationChecker $authorizationChecker, SchoolYearHelper $schoolYearHelper)
    {
        $this->entityManager = $em;
        $this->authorizationChecker = $authorizationChecker;
        $this->schoolYearHelper = $schoolYearHelper;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscriber = new AddFeesFieldScholarshipSubscriber($builder->getFormFactory(), $this->entityManager, $this->authorizationChecker,$this->schoolYearHelper);
        $builder
            ->add('registration', EntityType::class, [
                'class' => Registration::class,
                'label' => 'Inscription',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')->where("u.id =" . $options['id']);
                },
                'attr'  =>
                    [
                        'class' => 'form-control col-sm-12 col-md-4',
                    ]
            ]);
        
        $builder->addEventSubscriber($subscriber);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ScholarshipPayment::class,
            'id' => null,
        
        ]);
    }
}