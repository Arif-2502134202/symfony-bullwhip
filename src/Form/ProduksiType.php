<?php

namespace App\Form;

use App\Entity\Produksi;
use App\Entity\Pesanan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class ProduksiType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {    
        $builder
            ->add('pesanan')
            ->add('jumlah')
            ->add('leadtime')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produksi::class,
        ]);
    }

}

