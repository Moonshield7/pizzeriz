<?php

namespace App\Form;

use App\Entity\Pizza;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=> 'Nom :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez taper un nom',
                    ]),
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez taper une description',
                    ]),
                ]
            ])
            ->add('price', TextType::class, [
                'label' => 'Prix :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez taper un prix',
                    ]),
                ]
            ])
            // ->add('createdAt')
            // ->add('updatedAt')
            ->add('picture', FileType::class, [
                'label' => 'Photo :',
                'data_class' => null,
                'constraints' => [
                    new Image([
                       'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Les formats autorisés sont .jpg ou .png',
                        'maxSize' => '10M',
                        'maxSizeMessage' => 'Le poids maximal du fichier est : {{ limit }} {{ suffix }} ({{ name }}: {{ size }} {{ suffix }})',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => $options['picture'] ? 'Modifier' : 'Ajouter',
                'validate' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pizza::class,
            'allow_file_upload' => true,
            'picture' => null,
        ]);
    }
}
