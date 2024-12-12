<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('type')
            ->add('dateLancement', null, [
                'widget' => 'single_text',
            ])
            ->add('dateExpiration', null, [
                'widget' => 'single_text',
            ])
            ->add('prixOriginal')
            ->add('prixReduit')
            ->add('pourcentageReduction')
            ->add('statut')
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
