<?php

namespace App\Form;

use App\Entity\FutureEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateEventFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            // Vérifs et contraintes des champs
            ->add('eventDate', DateType::class,
                [
                'model_timezone' => 'Europe/Paris', //Date au format FR
                'widget' => 'single_text', //Date au format input date html
                'label' => "Date de l'évènement",
                'constraints' => [
                    new NotBlank([ // Erreur si le champ n'est pas rempli
                        'message' => 'Merci de saisir une date valide pour cet évènement'
                    ]),
                    new GreaterThan([ //Erreur si date antérieure à aujourd'hui
                        'value' => 'today',
                        'message' => "La date doit être postérieure à aujourd'hui."
                    ]),
                ]
            ])
            ->add('eventDescription', TextareaType::class, [
                'label' => "Description de l'évènement",
                'attr' => [
                  "rows" => 8,
                ],
                'constraints' => [
                    new NotBlank([ // Erreur si le champ n'est pas rempli
                        'message' => 'Merci de saisir une description pour cet évènement'
                    ]),
                ]
            ])
            ->add('save', SubmitType::class, ['label' => "Créer l'évènement"]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults(['data_class' => FutureEvent::class,]);
    }
}
