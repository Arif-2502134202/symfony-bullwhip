<?php

namespace App\Form;

use App\Entity\Pengambilan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PengambilanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder          
            ->add('pesanan')
            ->add('pengambil')
            ->add('jumlah')          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pengambilan::class,
        ]);
    }
}
