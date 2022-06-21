<?php

namespace App\Form;

use App\Entity\Shop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class EditShopTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [

                'label' => 'Nom de la boutique',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Le champs ne peux pas être vide'
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 100,

                        'minMessage' => 'Le nom de la boutique doit être de {{ limit }} characters de long',
                        'maxMessage' => 'Le nom de la boutique ne peux pas être plus grand que {{ limit }} characters ',
                    ])

                ]

            ])

            ->add('address', TextType::class, [

                'label' => 'Adresse',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Le champs ne peux pas être vide'
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 300,

                        'minMessage' => 'L\'adresse doit être de {{ limit }} characters de long',
                        'maxMessage' => 'L\'adresse  ne peux pas être plus grand que {{ limit }} characters ',
                    ])

                ]

            ])

            ->add('zip', TextType::class, [

                'label' => 'Code postale',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Le champs ne peux pas être vide'
                    ]),

                    new Regex([

                        'pattern' => '/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/',

                        'message' => 'Le code postale est invalide'

                    ])
                ]

            ])

            ->add('city', TextType::class, [

                'label' => 'Ville',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Le champs ne peux pas être vide'
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 100,

                        'minMessage' => 'La ville doit être de {{ limit }} characters de long',
                        'maxMessage' => 'La ville ne peux pas être plus grand que {{ limit }} characters ',
                    ])

                ]

            ])

            ->add('country', TextType::class, [

                'label' => 'Région',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Le champs ne peux pas être vide'
                    ]),

                    new Length([
                        'min' => 2,
                        'max' => 100,

                        'minMessage' => 'La région doit être de {{ limit }} characters de long',
                        'maxMessage' => 'La région ne peux pas être plus grand que {{ limit }} characters ',
                    ])

                ]

            ])

            ->add('phoneNumber', TelType::class, [

                'label' => 'Téléphone',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Le champs ne peux pas être vide'
                    ]),

                    new Regex([
                        'pattern' => '/^((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))$/u',
                        'message' => "Le numéro de téléphone est invalide."
                    ]),

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
            'data_class' => Shop::class,
        ]);
    }
}
