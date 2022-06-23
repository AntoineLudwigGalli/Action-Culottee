<?php

namespace App\Form;

use App\Entity\Shop;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CreateShopFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name' , TextType::class, [
                'label' => 'Nom de la boutique',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir le nom de votre boutique'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Le nom de la boutique doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom de la boutique ne peut contenir plus de {{ limit }} caractères'
                    ]),
                ],
            ])

            ->add('owner', EntityType::class, [
                'label' => 'Gérant',
                'placeholder' => 'Nom du gérant',
                'class' => 'App\Entity\User',
                'choice_value' => 'id',
                'choice_label' => function ($owner) {
                    return $owner->getFirstname() . ' ' . $owner->getLastname();
                },
            ])

            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de téléphone',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))$/u', // Accepte tous les numéros européens avec ou sans préfixes internationaux
                        'message' => "Merci de saisir un numéro de téléphone valide."
                    ]),
                    new NotBlank([
                        'message' => 'Merci de saisir le numéro de téléphone de la boutique.'
                    ]),
                ]
            ])

            ->add('address', TextType::class, [
                'label' => 'Adresse de la boutique',
                'attr' => [
                    'class' => "typeahead-address typeahead",
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir l\'adresse de votre boutique'
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 300,
                        'minMessage' => 'L\'adresse de la boutique doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'L\'adresse de la boutique ne peut contenir plus de {{ limit }} caractères'
                    ]),
                ],
            ])
// TODO : Verification et auto completion ville/code postal si on a le temps et qu'on s'ennuie.
            ->add('zip', TextType::class, [
                'label' => 'Code Postal',
                'attr' => [
                    'class' => "typeahead-zip",
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir le code postal de votre boutique'
                    ]),
                    new Regex([
                        'pattern' => '/^\d{5}$/u', // Accepte uniquement 5 chiffres
                        'message' => "Merci de saisir un code postal valide."
                    ]),
                ]
            ])

            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => "typeahead-city",
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir la ville dans laquelle se trouve votre boutique'
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 100,
                        'minMessage' => 'La ville dans laquelle se trouve votre boutique doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'La ville dans laquelle se trouve votre boutique ne peut contenir plus de {{ limit }} caractères'
                    ]),
                ],
            ])

            ->add('country', CountryType::class, [
                'label' => 'Pays :',
                'preferred_choices' => ['FR', 'BE', 'LU'], //Choix qui apparaissent en haut. Noté en format code ISO
                // 3166-1 Alpha-2
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Créer une boutique'
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
