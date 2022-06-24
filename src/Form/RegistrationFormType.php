<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        Création et paramétrage des champs du formulaire d'inscription
        $builder
//            Champs Email
            ->add('email', EmailType::class, [
                'label' => 'Adresse Email',
                'constraints' => [
                    new Email([
                        'message' => 'L\'adresse email {{ value }} n\'est pas une adresse valide',
                    ]),
                    new NotBlank([
                        'message' => 'Merci de saisir une adresse mail.'
                    ])
                ]
            ])
//            Checkbox CGU
            ->add('agreeTerms', CheckboxType::class, [
                'label_html' => true, //Permet de contourner l'échappement des balises HTML dans le label
                //    Mettre le vrai lien CGU
                'label' => 'Accepter les <a href="https://google.fr" target="_blank">conditions d\'utilisation</a>',
                'mapped' => false, //Permet d'ignorer le contrôle du champs avec les champs dans la BDD pour éviter
                // une erreur symfony
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions générales d\'utilisation',
                    ]),
                 
                ],
            ])

            //Champs Mot de passe et Confirmation du Mot de passe
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                ],
                'attr' => [
                    'autocomplete' => 'new-password' // Propose l'autocomplétion à l'utilisateur
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un mot de passe',
                    ]),
                    new Regex([
                        'pattern' => '/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ !\"\#\$%&\'\(\)*+,\-.\/:;<=>?@[\\^\]_`\{|\}~])^.{8,4096}$/u',
                        'message' => "Votre mot de passe doit contenir obligatoirement au moins une minuscule, une majuscule, un chiffre et un caractère spécial",
                    ]),
                    new Length([
                        'min' => 8,
                        'max' => 4096,
                        'minMessage' => "Votre mot de passe doit contenir au moins {{ limit }} caractères",
                        'maxMessage' => 'Votre mot de passe est trop grand'
                    ])
                ],
            ])

            // Champ Prénom
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre prénom'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Votre prénom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre prénom ne peut contenir plus de {{ limit }} caractères'
                    ]),
                ],
            ])
            // Champ Nom
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre nom'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Votre nom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre nom ne peut contenir plus de {{ limit }} caractères'
                    ]),
                ],
            ])
            // Champ numéro d'adhérent au bon format
            ->add('memberIdNumber', TextType::class, [
                'label' => "Numéro d'adhérent (facultatif)",
                "required" => false,
                'attr' => [
                    'placeholder' => 'Ex: 2022/123'
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^20[2-9]\d\/\d{3}$/u', // Quand je m'ennuie, seul, le soir, je fais des
                        // Regex !
                        'message' => "Le numéro d'adhérent doit être au format 20XX/XXX, par exemple 2022/123",
                    ]),
                ],
            ])
            // Champs numéro de téléphone français
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de téléphone',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))$/u', // Accepte tous les numéros européens avec ou sans préfixes internationaux
                        'message' => "Merci de saisir un numéro de téléphone valide."
                    ]),
                    new NotBlank([
                        'message' => 'Merci de saisir votre numéro de téléphone.'
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

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
