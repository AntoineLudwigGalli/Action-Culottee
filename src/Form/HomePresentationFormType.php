<?php

namespace App\Form;

use App\Entity\HomePresentation;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class HomePresentationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('presentationText', CKEditorType::class, [
                'purify_html' => true,
                'label' => "Texte de présentation",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un contenu'
                    ]),
                    new Length([
//                        todo: mettre une vraie valeur minimum
                        'min' => 1,
                        'minMessage' => 'Le contenu doit contenir au moins {{ limit }} caractères',
                        'max' => 5000,
                        'maxMessage' => 'Le contenu doit contenir au maximum {{ limit }} caractères'
                    ]),
                ]
            ])

            ->add('presentationImage', FileType::class, [
                'label' => 'Sélectionnez une photo',
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'L\'image doit être de type jpg ou png',
                        'maxSizeMessage' => 'Fichier trop volumineux ({{ size }} {{ suffix }}). La taille maximum autorisée est {{ limit }}{{ suffix }}',
                    ]),
                    new NotBlank([
                        'message' => 'Vous devez sélectionner un fichier',
                    ])
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary col-12'
        ]
    ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HomePresentation::class,
        ]);
    }
}
