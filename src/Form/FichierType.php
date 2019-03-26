<?php

namespace App\Form;

use App\Entity\Fichier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FichierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Cour' => 0,
                    'TD' => 1,
                    'TP' => 2,
                ],
            ])
            ->add('specialite', ChoiceType::class, [
                'choices' => [
                    'Informatique' => 0,
                    'Genie Logiciel' => 1,
                    "Systeme d'information" => 2,
                ],
            ])
            ->add(
                'annee',
                ChoiceType::class,
                [
                    'choices' => [
                        '2018' => 2018,
                        '2019' => 2019,
                        '2020' => 2020,
                        '2021' => 2021,
                        '2022' => 2022,
                        '2023' => 2023,
                        '2024' => 2024,
                    ],
                ]
            )
            ->add(
                'semestre',
                ChoiceType::class,
                [
                    'choices' => [
                        '1' => 1,
                        '2' => 2,
                    ],
                ]
            )
             ->add(
                'module',
                ChoiceType::class,
                [
                    'choices' => [
                        'Algorithme' => "Algorithme",
                        'Math' => "Math",
                    ],
                ]
            )
            ->add('pdfFile', FileType::class, array(
                'label' => 'Fichier',


            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fichier::class,
        ]);
    }
}
