<?php

namespace App\Form;

use App\Entity\Staff;
use App\Entity\Roles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class StaffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('kode')
            ->add('name')
            ->add('address')
            ->add('phone')
            ->add('email')
            ->add('password')
           // ->add('level')
            ->add('level', EntityType::class, [
                'class' => Roles::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('Roles')
                            ->orderBy('Roles.id', 'ASC');
                },
                'choice_label' => 'name',
                'choice_value' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Staff::class,
        ]);
    }
}
