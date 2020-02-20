<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   14/02/2020
 */

namespace App\Accounting\Form;


use App\Accounting\Entity\ExpenseLine;
use App\Accounting\Entity\ExpenseLineDocument;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

/**
 * Class ExpenseLineDocumentType
 *
 * @package App\Accounting\Form
 *
 */
class ExpenseLineDocumentType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'expenseLine', EntityType::class, [
                'class'         => ExpenseLine::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')->where("u.id =".$options['expense_line_id']);
                },
                'label'         => 'Ligne de dépense',
                'attr' => ['class' => 'form-control col-sm-12 col-md-4']
            ]
        )->add('label', TextType::class, ['label' => 'Libellé', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
                ->add('thumbnail', FileType::class, [
                    'mapped' => false,
    
                    // make it optional so you don't have to re-upload the PDF file
                    // every time you edit the Product details
                    'required' => false,
                    'attr' => ['class' => 'form-control col-sm-12 col-md-4'],
                    // unmapped fields can't define their validation using annotations
                    // in the associated entity, so you can use the PHP constraint classes
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'application/pdf',
                                'application/x-pdf',
                                'image/jpeg',
                                'image/gif',
                                'image/png',
                            ],
                            'mimeTypesMessage' => 'Please upload a valid document format (JPEG, PDF, GIF, PNG)',
                        ])
                        ]
                ])
                ->add('comment', TextareaType::class, ['label' => 'Commentaire', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
            [
                'data_class'      => ExpenseLineDocument::class,
                'id'              => null,
                'expense_line_id' => null,
            ]
        );
    }
    
}