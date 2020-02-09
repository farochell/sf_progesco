<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   08/02/2020
 * @time  :   13:37
 */

namespace App\Scoring\Form;


use App\Schooling\Entity\Registration;
use App\Scoring\Entity\ClassNote;
use App\Scoring\Entity\ClassNoteForm;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ClassNoteFormType
 *
 * @package App\Scoring\Form
 *
 */
class ClassNoteFormType extends AbstractType {
    
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('value', NumberType::class, ['label' => 'Valeur','attr'  => ['class' => 'form-control col-sm-12 col-md-4']])
                ->add('classNote', EntityType::class, [
                    'class' => ClassNote::class,
                    'label' => 'Note de classe',
                    'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                    'query_builder' => function (EntityRepository $er) use ($options) {
                        return $er->createQueryBuilder('u')
                                  ->where("u.id =" . $options['class_note_id']);
                    }
                ])->add('registration', EntityType::class, [
                'class' => Registration::class,
                'label' => 'Etudiant',
                'attr'  => ['class' => 'form-control col-sm-12 col-md-4'],
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')
                              ->where("u.id =" . $options['registration_id']);
                }
            ]);
    }
    
    /**
     *
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
            [
                'data_class'  => ClassNoteForm::class,
                'id'          => null,
                'registration_id' => null,
                'class_note_id'    => null,
            ]
        );
    }
}