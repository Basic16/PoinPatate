<?php

namespace App\Form;

use App\Entity\Variete;
use App\Entity\Calibre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ModifVarieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            
            ->add('idCalibre', EntityType::class,[
                'class'=>Calibre::class,
                'choice_label'=> "calibre",
                'multiple'=> 'true',
                ])

            ->add('modifierVariete', SubmitTYpe::class);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Variete::class,
        ]);
    }
}
