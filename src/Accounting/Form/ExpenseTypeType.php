<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   15/01/2020
 * @time  :   14:06
 */

namespace App\Accounting\Form;


use App\Accounting\Entity\ExpenseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ExpenseTypeType
 *
 * @package App\Accounting\Form
 *
 */
class ExpenseTypeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label', TextType::class, ['label' => 'Libellé', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ExpenseType::class,
                'id'         => null,
            ]
        );
    }
}