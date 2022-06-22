<?php

namespace App\Form;

use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PartnerTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Ce champs ne peux pas être vide',
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => "Le titre doit contenir au moins {{ limit }} caractères",
                        'maxMessage' => 'Le titre est trop grand'
                    ])

                ]
            ])

            ->add('logo', FileType::class, [

                'constraints' => [

                    new NotBlank([
                        'message' => 'Ce champs ne peux pas être vide'
                    ])

                ]

            ])

            ->add('description', TextType::class, [

                'label' => 'Description',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Ce champs ne peux pas être vide',
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => "La description doit contenir au moins {{ limit }} caractères",
                        'maxMessage' => 'La description est trop grande'
                    ])

                ]

            ])
            ->add('offer', TextType::class, [

                'label' => 'Offre du partenaire',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Ce champs ne peux pas être vide',
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => "L\'offre doit contenir au moins {{ limit }} caractères",
                        'maxMessage' => 'L\'offre est trop grande'
                    ])

                ]

            ])

            ->add('submit', SubmitType::class, [

                'label' => 'Crée le partenaire'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}
