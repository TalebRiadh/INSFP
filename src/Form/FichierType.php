<?php

namespace App\Form;

use App\Entity\Fichier;
use App\Entity\Specialite;
use App\Entity\Module;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                    'Document' => 3,
                ],
            ])
            ->add('specialite', EntityType::class, [
            'class' => Specialite::class,
            'label' =>'Specialité',
            'choice_label' => 'name'])
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
                        '3' => 3,
                        '4' => 4,
                        '5' => 5,

                    ],
                ]
            )
             ->add(
                'module',
                EntityType::class, [
            'class' => Module::class,
            'label' =>'Module',
            'choice_label' => 'nom'])
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
