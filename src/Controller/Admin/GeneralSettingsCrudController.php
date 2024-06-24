<?php

namespace App\Controller\Admin;


use App\Entity\GeneralSettings;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GeneralSettingsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GeneralSettings::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Paramètres généraux')
            ->setEntityLabelInPlural('Paramètres généraux');
    }

    public function configureActions(Actions $actions): Actions
    {
        if (in_array('ROLE_MODO', $this->getUser()->getRoles())) {
            return $actions
                ->disable(Action::DELETE)
                ->disable(Action::NEW);
        }
        return $actions;
    }
    


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('siteName', 'Nom du site'),
            TextField::new('siteAddress', 'Adresse'),
            EmailField::new('siteEmail', 'Email'),
            ImageField::new('siteLogo', 'Logo')
                ->setUploadDir('public/uploads')
                ->setBasePath('uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            TextField::new('siteTel', 'Téléphone'),
            UrlField::new('fbLink', 'Lien Facebook')->setHelp('Lien de la page Facebook'),
            UrlField::new('whatsappLink', 'Lien WhatsApp')->setHelp('Lien de la page WhatsApp'),
        ];
    }
}
