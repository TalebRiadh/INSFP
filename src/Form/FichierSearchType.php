<?php

namespace App\Form;

use App\Entity\FichierSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichierSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('module', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Module',
                'label' =>false,
                'choices' => [
                    'informatique' => 0,
                    'genie logiciel' => 1,
                    "System d'information" => 2,
                ],
                'attr' => [
                    'placeholder' => 'Module'
                ]
            ])
            ->add('specialite', ChoiceType::class, [
                'required' => false,
                'label' =>false,
                    'placeholder' => 'Spécialité',

                'choices' => [
                    'informatique' => 0,
                    'genie logiciel' => 1,
                    "System d'information" => 2,
                ],
                'attr' => [
                    'placeholder' => 'Specialité'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FichierSearch::class,
            'method' => 'get',
            'csrf_protection' => false

        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
