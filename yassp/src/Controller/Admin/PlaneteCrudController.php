<?php

namespace App\Controller\Admin;

use App\Entity\Planete;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlaneteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Planete::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('nom'),
            NumberField::new('taille'),
            NumberField::new('distance'),
            textField::new('name'),
            AssociationField::new('galaxie')
        ];
    }
}
