<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Specialite;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder     
               ->add('name',TextType::class,array(
                   'label' => 'Formation',
                   
               ))
                ->add('Specialite', EntityType::class, array(
            'label' => 'Specialite',
            'required' => true,
            'class' => 'App\Entity\Specialite',
            'choice_label' => 'name',
            'required' => false,
            'multiple' => true,
            'mapped' => false,
        ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
