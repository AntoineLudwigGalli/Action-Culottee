<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UpdateUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        Création et paramétrage des champs du formulaire de modification d'un utilisateur
        $builder
//            Champs Email
            ->add('email', EmailType::class, [

                'label' => 'Adresse Email',
                "empty_data" => "",
                'constraints' => [
                    new Email([
                        'message' => 'L\'adresse email {{ value }} n\'est pas une adresse valide',
                    ]),
                    new NotBlank([
                        'message' => 'Merci de saisir une adresse mail.'
                    ])
                ]
            ])

            // Champ Prénom
            ->add('firstname', TextType::class, [
                "empty_data" => "",
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un prénom'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le prénom ne peut contenir plus de {{ limit }} caractères'
                    ]),
                ],
            ])
            // Champ Nom
            ->add('lastname', TextType::class, [
                "empty_data" => "",
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un nom'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom ne peut contenir plus de {{ limit }} caractères'
                    ]),
                ],
            ])
            // Champ numéro d'adhérent au bon format
            ->add('memberIdNumber', TextType::class, [
                'label' => "Numéro d'adhérent (facultatif)",
                "required" => false,
                'attr' => [
                    'placeholder' => 'Ex: 2022/123',
                    "required" => false,
                ],
                'constraints' => [

                    new Regex([
                        'pattern' => '/^20[2-9]\d\/\d{3}$/u',
                        'message' => "Le numéro d'adhérent doit être au format 20XX/XXX, par exemple 2022/123",
                    ]),
                ],
            ])
            // Champs numéro de téléphone français
            ->add('phoneNumber', TelType::class, [
                "empty_data" => "",
                'label' => 'Numéro de téléphone',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))$/u', // Accepte tous les numéros européens avec ou sans préfixes internationaux
                        'message' => "Merci de saisir un numéro de téléphone valide."
                    ]),
                    new NotBlank([
                        'message' => 'Merci d\'indiquer un numéro de téléphone.'
                    ]),
                ],
            ])

            // Choix de l'abonnement à la newsletter
            ->add('newsletterOption', ChoiceType::class, [
                'label' => 'Souhaitez-vous recevoir la newsletter ?',
                'expanded' => true,
                'multiple' => false, //expanded et multiple permettent d'avoir des boutons radio plutôt qu'un menu
                // déroulant
                'choices' => [
                    'Oui' => "1",
                    'Non' => "0",
                ],
                'empty_data' => "0",
            ])


            ->add('isVerified', ChoiceType::class, [
                'label' => "L'utilisateur a été vérifié et le compte est valide ?",
                'expanded' => true,
                'multiple' => false, //expanded et multiple permettent d'avoir des boutons radio plutôt qu'un menu
                // déroulant
                'choices' => [
                    'Oui' => "1",
                    'Non' => "0",
                ],
                'empty_data' => "0",
            ])

            ->add('membershipPaid', ChoiceType::class, [
                'label' => "L'utilisateur est-il à jour de sa cotisation ?",
                'expanded' => true,
                'multiple' => false, //expanded et multiple permettent d'avoir des boutons radio plutôt qu'un menu
                // déroulant
                'choices' => [
                    'Oui' => "1",
                    'Non' => "0",
                ],
                'empty_data' => "0",
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Modifier l\'utilisateur'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
