<?php

namespace App\Form;

use App\Entity\Frigos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModifFrigoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class)
        ->add('CSV', FileType::class, array('data_class' => null))
        ->add('Stockage', NumberType::class)
        /*->add('idVariete',NumberType::class)
        ->add('idProducteurs',NumberType::class)*/
        ->add('modif_frigo', SubmitType::class)
    ;   
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Frigos::class,
        ]);
    }
}
