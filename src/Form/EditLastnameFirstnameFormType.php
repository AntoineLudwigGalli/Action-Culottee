<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditLastnameFirstnameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        // Construction du formulaire
        $builder
            ->add('lastname', TextType::class, [
                "empty_data" => "",
                'constraints' => [

                    new NotBlank([
                        'message' => 'Le champs ne peux pas être vide'
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 100,

                        'minMessage' => 'Ton nom doit être de {{ limit }} characters de long',
                        'maxMessage' => 'Ton nom ne peux pas être plus grand que {{ limit }} characters ',
                    ])

                ]

            ])
            ->add('firstname', TextType::class, [
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champs ne peux pas être vide'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => 'Ton prénom doit être de {{ limit }} characters de long',
                        'maxMessage' => 'Ton prénom ne peux pas être plus grand que {{ limit }} characters ',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
