<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnimalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Animal::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user')
                ->setLabel('Propriétaire'),
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('name')
                ->setLabel('Nom'),
            IntegerField::new('identification_number')
                ->setLabel('Numéro identification'),
            IntegerField::new('tatoo_number')
                ->setLabel('Numéro tatoo'),
            ChoiceField::new('sex')
                ->setLabel('Sexe')
                ->setChoices([
                    'Mâle' => 'Mâle',
                    'Femelle' => 'Femelle',
                    'Autre' => 'Autre',
                ]),
            DateField::new('birth_date')
                ->setLabel('Date de naissance'),
            DateField::new('sterilisation_date')
                ->hideOnIndex()
                ->setLabel('Date de stérilisation'),
            TextField::new('breed_type')
                ->setLabel('Race'),
            TextField::new('color')
                ->setLabel('Couleurs'),
            TextareaField::new('distinctive_marks')
                ->hideOnIndex()
                ->setLabel('Marques distinctives'),
        ];
    }
}
