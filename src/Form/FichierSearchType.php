<?php

namespace App\Form;

use App\Entity\FichierSearch;
use App\Entity\Specialite;
use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FichierSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('module',  EntityType::class, [
            'class' => Module::class,
            'choice_label' => 'nom'])
            ->add('specialite',  EntityType::class, [
            'class' => Specialite::class,
            'choice_label' => 'name']);
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
