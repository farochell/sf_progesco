<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   12:17
 */

namespace App\Accounting\Listener;


use App\Accounting\Entity\Tuition;
use App\Pedagogy\Entity\Grade;
use App\Pedagogy\Entity\Level;
use App\Pedagogy\Helper\SchoolYearHelper;
use App\Schooling\Entity\Registration;
use App\Student\Entity\Student;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class AddFeesFieldScholarshipSubscriber
 *
 * @package App\Accounting\Listener
 *
 */
class AddFeesFieldScholarshipSubscriber implements EventSubscriberInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;
    /**
     * @var
     */
    private $em;
    
    /**
     * @var
     */
    private $authorizationChecker;
    
    private $schoolYearHelper;
    
    /**
     * @param FormFactoryInterface $factory
     * @param                      $em
     * @param                      $authorizationChecker
     * @param SchoolYearHelper     $schoolYearHelper
     */
    public function __construct(FormFactoryInterface $factory, $em, $authorizationChecker, SchoolYearHelper $schoolYearHelper)
    {
        $this->factory              = $factory;
        $this->em                   = $em;
        $this->authorizationChecker = $authorizationChecker;
        $this->schoolYearHelper     = $schoolYearHelper;
    }
    
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [FormEvents::POST_SET_DATA => 'preSetData'];
    }
    
    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        try {
            $payment    = $event->getData();
            $form       = $event->getForm();
            $attributes = $form->getConfig()->getOptions();
            $id         = $attributes['id'];
            $fees       = null;
            if (!$payment || null === $payment->getId()) {
                $registration = $this->em->getRepository(Registration::class)->find($id);
                $grade        = $this->em->getRepository(Grade::class)->find($registration->getGrade()->getId());
                // Level ID retrieval
                $level = $this->em->getRepository(Level::class)->find($grade->getLevel()->getId());
                // Tuitions retrieval
                $tuitions = $this->em->getRepository(Tuition::class)->findBy(
                    ['level' => $level->getId(), 'schoolYear' => $this->schoolYearHelper->getActiveYear()]
                );
                foreach ($tuitions as $tuition) {
                    // Get studies
                    $studies = $tuition->getStudies();
                    foreach ($studies as $study) {
                        if ($study->getId() == $grade->getStudy()->getId()) {
                            $fees = $tuition->getFees();
                        }
                    }
                    if ($fees == null) {
                        $fees = $tuition->getFees();
                    }
                }
                
                $student = $registration->getStudent();
                
                $form->add(
                    'student',
                    EntityType::class,
                    [
                        'class'         => Student::class,
                        'mapped'        => false,
                        'query_builder' => function (EntityRepository $er) use (
                            $student
                        ) {
                            return $er->createQueryBuilder('u')->where("u.id =".$student->getId());
                        },
                        'label'         => 'Etudiant',
                        
                        'attr' =>
                            [
                                'class' => 'form-control col-sm-12 col-md-4',
                            ],
                    
                    
                    ]
                );
                
                if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                    if ($fees) {
                        $form->add(
                            'tuition',
                            TextType::class,
                            [
                                'label' => 'Frais de scolarité',
                                'data'  => $fees,
                                'attr'  =>
                                    [
                                        'class' => 'form-control col-sm-12 col-md-4',
                                    ],
                            ]
                        );
                    } else {
                        $form->add(
                            'tuition',
                            TextType::class,
                            [
                                'label' => 'Frais de scolarité',
                                'attr'  =>
                                    [
                                        'class' => 'form-control col-sm-12 col-md-4',
                                    ],
                            ]
                        );
                    }
                } else {
                    if ($fees) {
                        $form->add(
                            'tuition',
                            TextType::class,
                            [
                                'label' => 'Frais de scolarité',
                                'data'  => $fees,
                                'attr'  => ['class' => 'form-control col-sm-12 col-md-4', 'readonly' => true],
                            ]
                        );
                        
                    } else {
                        $form->add(
                            'tuition',
                            TextType::class,
                            [
                                'label' => 'Frais de scolarité',
                                'attr'  => ['class' => 'form-control col-sm-12 col-md-4', 'readonly' => true],
                            ]
                        );
                    }
                    
                }
                
                if ($fees == null) {
                    $form->get('tuition')->addError(new FormError('Aucun frais défini pour l\'année scolaire en cours'));
                    $form->add(
                        'tuition',
                        TextType::class,
                        [
                            'label' => 'Frais de scolarité',
                            'attr'  => ['class' => 'form-control col-sm-12 col-md-4', 'readonly' => true],
                        ]
                    );
                }
                
            }
        } catch (\Exception $e) {
        
        }
    }
}