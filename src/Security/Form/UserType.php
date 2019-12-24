<?php

/**
 * Created by PhpStorm.
 * User: Emile
 * Date: 03/02/2018
 * Time: 13:39
 */

namespace App\Security\Form;

use App\Security\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType
 * @package App\Security\Form
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'E-mail', 'attr' => ['class' => 'form-control']])
            ->add('username', TextType::class, ['label' => 'Identifiant', 'attr' => ['class' => 'form-control']])
            ->add('lastName', TextType::class, ['label' => 'Nom', 'attr' => ['class' => 'form-control']])
            ->add('firstName', TextType::class, ['label' => 'Prénom', 'attr' => ['class' => 'form-control']])
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type'           => PasswordType::class,
                    'first_options'  => ['label' => 'Mot de passe', 'attr' => ['class' => 'form-control']],
                    'second_options' => ['label' => 'Repeter le mot de passe', 'attr' => ['class' => 'form-control']],
                
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
                'data_class' => User::class,
                'id'         => null,
            ]
        );
    }
}