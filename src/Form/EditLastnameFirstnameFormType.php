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
                        'message' => 'Le champ ne peux pas être vide'
                    ]),

                    new Length([
                        'min' => 3,
                        'max' => 100,

                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le nom doit contenir au maximum {{ limit }} caractères',
                    ])

                ]

            ])
            ->add('firstname', TextType::class, [
                "empty_data" => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne peux pas être vide'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le prénom doit contenir au maximum {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [

                'label' => 'Modifier',

                'attr' => [

                    'class' => 'btn-edit'

                ]

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
