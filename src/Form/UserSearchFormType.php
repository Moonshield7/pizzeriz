<?php

namespace App\Form;

use App\DTO\UserSearchCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UserSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('limit', IntegerType::class, [
                'label' => 'Nombre de résultat par page :',
                'required' => false,
                'empty_data' => '15',
            ])
            ->add('page', IntegerType::class, [
                'label' => 'Page :',
                'required' => false,
                'empty_data' => '1',
            ])
            ->add('orderBy', ChoiceType::class, [
                'label' => 'Trier par :',
                'required' => false,
                'choices' => [
                    'Identifiant' => 'id',
                    'Nom' => 'name',
                ],
                'empty_data' => 'createdAt',
            ])
            ->add('direction', ChoiceType::class, [
                'label' => 'Sens du tri :',
                'required' => false,
                'choices' => [
                    'Croissant' => 'ASC',
                    'Décroissant' => 'DESC',
                ],
                'empty_data' => 'ASC',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserSearchCriteria::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
