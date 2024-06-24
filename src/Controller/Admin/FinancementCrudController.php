<?php

namespace App\Controller\Admin;

use App\Entity\Financement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FinancementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Financement::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Financement')
            ->setEntityLabelInPlural('Financements');
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
            TextField::new('pageTitle', 'Titre de la page'),
            TextEditorField::new('content', 'Contenu de la page'),
        ];
    }
}
