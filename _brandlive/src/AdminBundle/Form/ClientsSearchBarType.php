<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\{AbstractType,FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{TextType,TextareaType};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AdminBundle\Entity\Groups;
use AdminBundle\Repository\GroupsRepository;

class ClientsSearchBarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keyword', TextType::class, [
                'label' => 'Buscador (Nombre,Apellido,Email)',
                'required' => false,
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
        ;
    }
}
