<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('duree')
            ->add('dateCreation', DateType::class, [
                'label' => 'Date of Creation',
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
                'data' => new \DateTime(), // Set default value
            ])            
            ->add('date', DateType::class, [
                'label' => 'Date of Meeting',
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
                'data' => new \DateTime(), // Set default value
            ])
            ->add('heureDebut', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
    
}
