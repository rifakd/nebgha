<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType; // Add this import


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

            ->add('coursePdfFile', VichFileType::class, [
                'label' => 'Course PDF',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => ['application/pdf'],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
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
