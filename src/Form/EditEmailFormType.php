<?php

namespace App\Form;

use App\Entity\User;
use MongoDB\BSON\Regex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditEmailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [

                "empty_data" => '',

                'constraints' => [

                    new NotBlank([
                        'message' => 'Le champ ne doit pas être vide'
                    ]),

                    new Email([
                        'message' => 'Votre email n\'est pas valide'
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 180,

                        'minMessage' => 'L\'email doit contenir au minimum {{ limit }} caractères',
                        'maxMessage' => 'L\' email ne peux pas contenir plus de {{ limit }} caractères ',
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
            'data_class' => User::class,
        ]);
    }
}