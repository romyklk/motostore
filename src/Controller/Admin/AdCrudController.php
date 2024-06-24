<?php

namespace App\Controller\Admin;

use App\Entity\Ad;
use App\Form\Type\AdImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ad::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Annonce')
            ->setEntityLabelInPlural('Annonces');
    }





    public function configureFields(string $pageName): iterable
    {
        $currentYear = date('Y');
        $years = array_combine(range($currentYear, 1990), range($currentYear, 1990));

        return [
            TextField::new('reference', 'Référence')->hideOnForm(),
            TextField::new('title', 'Titre'),
            AssociationField::new('mark', 'Marque'),
            ChoiceField::new('year', 'Année')->setChoices($years),
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            IntegerField::new('mileage', 'Kms'),
            ChoiceField::new('fuel', 'Carburant')->setChoices([
                'Essence' => 'Essence',
                'Diesel' => 'Diesel',
                'Electrique' => 'Electrique',
                'Hybride' => 'Hybride',
            ]),
            IntegerField::new('puissance', 'Puissance')->hideOnIndex(),
            IntegerField::new('cylindre', 'Cylindrée')->hideOnIndex(),

            TextEditorField::new('description', 'Description')->hideOnIndex(),

            ImageField::new('mainPicture', 'Photo Principale')
            ->setUploadDir('public/uploads/ads')
            ->setBasePath('uploads/ads')
            ->setUploadedFileNamePattern('[year][month][day]' . uniqid() . '[contenthash].[extension]')->setRequired(false),

            BooleanField::new('active', 'actif ?'),
            BooleanField::new('reserved', 'Réservé ?'),


            CollectionField::new('images', 'Images')
                ->setEntryType(AdImageType::class)
                ->renderExpanded(false)
                ->onlyOnForms(),


        ];
    }
}
