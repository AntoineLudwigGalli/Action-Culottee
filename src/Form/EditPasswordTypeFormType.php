<?php

namespace App\Form;


use App\Security\ChangePassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class EditPasswordTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',

                'constraints' => [

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
                ]
            ])
            ->add('newPassword', RepeatedType::class, [

                'type' => PasswordType::class,

                'invalid_message' => 'Le mot de passe ne match pas',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Le champs ne peux pas être vide'
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

                'first_options'  => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Répéter le mot de passe']

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChangePassword::class,
        ]);
    }
}