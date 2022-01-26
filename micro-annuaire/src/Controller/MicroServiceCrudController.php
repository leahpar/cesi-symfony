<?php

namespace App\Controller;

use App\Entity\MicroService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field;

class MicroServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MicroService::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield Field\ChoiceField::new('groupe')
            ->setChoices(MicroService::GROUPES);

        yield Field\ChoiceField::new('service')
            ->setChoices(MicroService::SERVICES);

        yield Field\UrlField::new('git')
            ->setFormTypeOption("attr.placeholder", "https://gitlab.com/toto")
            ->hideOnIndex();

        yield Field\UrlField::new('host')
            ->setFormTypeOption("attr.placeholder", "https://10.176.130.2xx")
            ->setHelp("IP locale sur le réseau")
            ->hideOnIndex();

        yield Field\IntegerField::new('port')
            ->setFormTypeOption("attr.placeholder", "8080")
            ->hideOnIndex();

        yield Field\TextField::new('url')
            ->setLabel('URL du service')
            ->onlyOnIndex();

        yield Field\TextField::new('urlPing')
            ->setFormTypeOption("attr.placeholder", "/api/ping")
            ->setHelp("Url quelconque de l'api qui retourne un code HTTP 200")
            ->hideOnIndex();

        yield Field\UrlField::new('urlToHome')
            ->setLabel("URL accueil/doc")
            ->hideOnForm();

        yield Field\TextField::new('urlHome')
            ->setFormTypeOption("attr.placeholder", "/")
            ->setHelp("URL d'accueil du site ou url de la doc de l'api")
            ->onlyOnForms();

        yield Field\IntegerField::new('ping')
            ->setNumberFormat("%d ms")
            ->hideOnForm();

    }
}
