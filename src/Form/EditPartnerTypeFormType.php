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

class EditPartnerTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [

                'label' => 'Marque',

                "empty_data" => '',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Ce champ ne peux pas être vide',
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => "Le titre doit contenir au moins {{ limit }} caractères",
                        'maxMessage' => 'Le titre ne peut pas contenir plus de {{ limit }} caractères'
                    ])

                ]
            ])

            ->add('logo', FileType::class, [
                'data_class' => null,

                "empty_data" => '',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Ce champ ne peux pas être vide',
                    ]),

                ]
            ])

            ->add('description', CKEditorType::class, [

                'label' => 'Description',

                'purify_html' => true,

                "empty_data" => '',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Ce champ ne peux pas être vide',
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 1_500,
                        'minMessage' => "La description doit contenir au moins {{ limit }} caractères",
                        'maxMessage' => 'La description ne peut pas contenir plus de {{ limit }} caractères'
                    ])

                ]

            ])
            ->add('offer', CKEditorType::class, [

                'label' => 'Offre du partenaire',

                'purify_html' => true,

                "empty_data" => '',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Ce champ ne peux pas être vide',
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 1_500,
                        'minMessage' => "L\'offre doit contenir au moins {{ limit }} caractères",
                        'maxMessage' => 'L\'offre ne peut pas contenir plus de {{ limit }} caractères'
                    ])

                ]

            ])

            ->add('submit', SubmitType::class, [

                'label' => 'Modifier'

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
