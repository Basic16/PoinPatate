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

class AjoutFrigosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
          
            ->add('Largeur', NumberType::class, array(
                
                'mapped' => false))
                ->add('Longueur', NumberType::class, array(
                
                    'mapped' => false))
        
            ->add('ajout_frigo', SubmitType::class)
        ;   
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Frigos::class,
        ]);
    }
}
