<?php

namespace App\Form;

use App\Entity\Partner;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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

                'label' => 'Marque',

                "empty_data" => '',

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

            ->add('logo', FileType::class, [ 'data_class' => null ])

            ->add('description', CKEditorType::class, [

                'label' => 'Description',

                "empty_data" => '',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Ce champs ne peux pas être vide',
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 5000,
                        'minMessage' => "La description doit contenir au moins {{ limit }} caractères",
                        'maxMessage' => 'La description est trop grande'
                    ])

                ]

            ])
            ->add('offer', CKEditorType::class, [

                'label' => 'Offre du partenaire',

                "empty_data" => '',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Ce champs ne peux pas être vide',
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 5000,
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
