<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id'),
            TextField::new('email'),
            ChoiceField::new('roles')
                ->setChoices([
                    "ROLE_ADMIN" => "ROLE_ADMIN",
                    "ROLE_AUTEUR" => "ROLE_AUTEUR",
                ])
                ->allowMultipleChoices(true),

            TextField::new('plainPassword')
                ->setRequired(false)
                ->setHelp("Laisser vide pour ne pas changer le mot de passe")
                ->onlyWhenCreating(),

            TextField::new('plainPassword')
                ->setRequired(false)
                ->setHelp("Laisser vide pour un mot de passe aléatoire")
                ->onlyWhenUpdating(),
        ];
    }

}
