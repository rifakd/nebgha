<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Count;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', TextareaType::class, [
                'label' => 'Question',
                'attr' => [
                    'placeholder' => 'Enter your question here',
                    'class' => 'form-control',
                    'rows' => 3
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 10])
                ]
            ])
            ->add('choices', CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => [
                    'attr' => [
                        'placeholder' => 'Enter an answer choice',
                        'class' => 'form-control'
                    ],
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 1])
                    ]
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Answer Choices',
                'prototype' => true,
                'required' => true,
                'constraints' => [
                    new Count([
                        'min' => 2,
                        'minMessage' => 'You must specify at least {{ limit }} choices'
                    ])
                ]
            ]);
            
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            
            if (isset($data['choices']) && is_array($data['choices'])) {
                $choices = array_combine($data['choices'], $data['choices']);
                
                $form->add('reponseCorrecte', ChoiceType::class, [
                    'label' => 'Correct Answer',
                    'choices' => $choices,
                    'required' => true,
                    'constraints' => [
                        new NotBlank()
                    ]
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class
        ]);
    }
}