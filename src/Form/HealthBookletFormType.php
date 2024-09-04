<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HealthBookletFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
                'attr' => ['class' => 'field'],
            ])
            ->add('identification_number', null, [
                'label' => 'Numéro d\'indentification',
                'attr' => ['class' => 'field'],
            ])
            ->add('tatoo_number', null, [
                'label' => 'Numéro de tatouage',
                'attr' => ['class' => 'field'],
            ])
            ->add('sex', null, [
                'label' => 'Sexe',
                'attr' => ['class' => 'field'],
            ])
            ->add('birth_date', null, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr' => ['class' => 'field'],
            ])
            ->add('sterilisation_date', null, [
                'label' => 'Date de stérilisation',
                'widget' => 'single_text',
                'attr' => ['class' => 'field'],
            ])
            ->add('breed_type', null, [
                'label' => 'Race',
                'attr' => ['class' => 'field'],
            ])
            ->add('color', null, [
                'label' => 'Couleur',
                'attr' => ['class' => 'field'],
            ])
            ->add('distinctive_marks', null, [
                'label' => 'Marques distinctives',
                'attr' => ['class' => 'field'],
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
