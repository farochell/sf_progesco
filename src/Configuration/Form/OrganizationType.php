<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   14/01/2020
 * @time  :   11:30
 */

namespace App\Configuration\Form;


use App\Configuration\Entity\Organization;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'Nom', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
            ->add('academy', TextType::class, ['label' => 'Académie', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
            ->add('directorName', TextType::class, ['label' => 'Nom du directeur', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
            ->add('phone1', TextType::class, ['label' => 'Téléphone 1', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
            ->add('phone2', TextType::class, ['label' => 'Téléphone 2', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
            ->add('email', TextType::class, ['label' => 'Adresse e-mail', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
            ->add('postalCode', TextType::class, ['label' => 'Code postale', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
            ->add('address', TextareaType::class, ['label' => 'Adresse', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
            ->add('city', TextType::class, ['label' => 'Ville', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
            ->add('country', TextType::class, ['label' => 'Pays', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
            ->add('webSite', TextType::class, ['label' => 'Site Web', 'attr' => ['class' => 'form-control col-sm-12 col-md-4']])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Organization::class,
                'id'         => null,
            ]
        );
    }
}