<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('identification_number')
            ->add('tatoo_number')
            ->add('sex')
            ->add('birth_date', null, [
                'widget' => 'single_text',
            ])
            ->add('sterilisation_date', null, [
                'widget' => 'single_text',
            ])
            ->add('breed_type')
            ->add('color')
            ->add('distinctive_marks')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
