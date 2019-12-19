<?php

namespace App\Security\Form;

use App\Security\Entity\Role;
use App\Security\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddUserRoleType
 *
 * @package App\Security\Form
 *
 */
class AddUserRoleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('user', EntityType::class, [
            'class'         => User::class,
            'mapped' => false,
            'query_builder' => function (EntityRepository $er) use ($options) {
            return $er->createQueryBuilder('u')->where("u.id =" . $options['id']);
            }
            ])
            ->add('roles', EntityType::class, [
                    'class' => Role::class,
                    'multiple' => true,
                    'expanded' => false,
                    'group_by'  => function (Role $role) {
                        return $role->getMenu();
                    }
                ]);      
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([            
            'id' => null,
        ]);
    }
}