<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\FilesType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;


class NewsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('discription')
            ->add('date_de_evenement', DateType::class, [
        'widget' => 'single_text',
    // this is actually the default format for single_text
        'format' => 'yyyy-MM-dd'])
       ->add('start',  TimeType::class, [
           'label'=> 'debut',
                   'widget' => 'single_text',

    'placeholder' => [
        'hour' => 'Heure', 'minute' => 'Minute'
    ],
])
  ->add('end',  TimeType::class, [
                 'label'=> 'fin',

    'widget' => 'single_text',
    'placeholder' => [
        'hour' => 'Heure', 'minute' => 'Minute'
    ],
])
            ->add('files', CollectionType::class, array(
                'entry_type' => FilesType::class,
                'allow_add' => true,
                'by_reference' => false,
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\News'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }
}
