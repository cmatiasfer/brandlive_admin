<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\{AbstractType,FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{TextType,TextareaType};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


use AdminBundle\Entity\Clients;
use AdminBundle\Entity\Groups;
use AdminBundle\Repository\GroupsRepository;

class ClientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => ['class' => 'form-group form-control']
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Apellido',
                'empty_data' => '',
                'attr' => ['class' => 'form-group form-control']
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'empty_data' => '',
                'attr' => ['class' => 'form-group form-control']
            ])
            ->add('groups', EntityType::class , array(
                'label' => 'Grupo',
                'class' => Groups::class,
                'expanded' => true,
                'multiple' => true,
                'mapped' => false,
                'expanded' => true,
                'query_builder' => function (GroupsRepository $gr) {
                    return $gr->createQueryBuilder('g')
                        ->orderBy('g.name', 'ASC');
                },
                'choice_label' => 'name',
            ))
            ->add('observation', TextareaType::class, [
                'label' => 'Observaciones',
                'empty_data' => '',
                'attr' => ['class' => 'form-group form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
        ]);
    }
}
