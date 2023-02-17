<?php

namespace App\Controller\Admin;

use App\Entity\Galaxie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GalaxieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Galaxie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
        ];
    }

}
