<?php

namespace App\Form;

use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SpecialiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder     
               ->add('name',TextType::class,array(
                   'label' => 'Specialité',
                   
               ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Specialite::class,
        ]);
    }
}
