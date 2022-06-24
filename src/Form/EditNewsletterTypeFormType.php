<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditNewsletterTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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

            ->add('submit', SubmitType::class, [
                'label' => 'Valider',

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
