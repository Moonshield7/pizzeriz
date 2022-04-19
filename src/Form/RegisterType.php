<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'label' => 'Email : ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut être vide',
                    ]),
                    new Length([
                        'max' => 180,
                        'maxMessage' => 'Votre email ne peut dépasser {{ limit }} caractères',
                    ]),
                    new Email([
                        'message' => 'Votre email n\'est pas au bon format: ex. mail@example.com'
                    ]),
                ],
            ])
            /* ->add('roles') */
            ->add('password', PasswordType::class,[
                'label' => 'Mot de passe :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut être vide',
                    ]),
                    new Length([
                        'max' => 255,
                        'min' => 4,
                        'maxMessage' => 'Votre mot de passe ne peut dépasser {{ limit }} caractères',
                        'minMessage' => 'Votre mot de passe doit avoir au minimum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class,[
                'label' => 'Mot de passe :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut être vide',
                    ]),
                    new Length([
                        'max' => 255,
                        'min' => 4,
                        'maxMessage' => 'Votre mot de passe ne peut dépasser {{ limit }} caractères',
                        'minMessage' => 'Votre mot de passe doit avoir au minimum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir un nom',
                    ]),
                ]
            ])
            ->add('phoneNumber', TextType::class,[
                'label' => "Téléphone : ",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut être vide',
                    ]),
                    new Length([
                        'max' => 10,
                        'min' => 10,
                        'maxMessage' => 'Votre numéro de téléphone ne peut dépasser {{ limit }} chiffres',
                        'minMessage' => 'Votre numéro de téléphone doit avoir au minimum {{ limit }} chiffres',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville : ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir une ville',
                    ]),
                ]
            ])
            ->add('postalCode', TextType::class,[
                'label' => 'Code Postal : ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut être vide',
                    ]),
                    new Length([
                        'max' => 5,
                        'min' => 5,
                        'maxMessage' => 'Votre code postal ne peut dépasser {{ limit }} chiffres',
                        'minMessage' => 'Votre code postal doit avoir au minimum {{ limit }} chiffres',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse : ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez taper une adresse',
                    ]),
                ]
            ])
            ->add('complement', TextareaType::class, [
                'label' => 'Complément : '
            ])
            /* ->add('createdAt') */
            /* ->add('updatedAt') */
            // ->add('submit', SubmitType::class, [
            //     'label' => 'S\'incrire',
            //     'attr' => [
            //         'class' => 'btn btn-success col-6 justify-content-center'
            //     ]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
