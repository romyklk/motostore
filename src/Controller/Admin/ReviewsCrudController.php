<?php

namespace App\Controller\Admin;

use App\Entity\Reviews;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReviewsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reviews::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Les Avis clients')
            ->setEntityLabelInPlural('Les Avis clients');
    }


    public function configureFields(string $pageName): iterable
    {
        $rate = range(1, 5);
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            ChoiceField::new('stars', 'Nombre d\'étoiles')->setChoices(fn() => array_combine($rate, $rate)),
            DateTimeField::new('reviewsDate', 'Date de l\'avis'),
            TextField::new('clientName', 'Nom du client'),
            TextField::new('title', 'Titre'),
            TextEditorField::new('content', 'Contenu'),


           

        ];
    }
    
}
