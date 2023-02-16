# Yassp !

> Yet Another Symfony Syper Project


Créer une entité :

```php bin/console make:entity```

Mise à jour de la bdd :

```php bin/console doctrine:schema:update --dump-sql```

```php bin/console doctrine:schema:update --force```


## CRUD 'fait maison'

URL: `.../planetes`

PHP: `src/Controller/PlaneteController.php`

Form: `src/Form/PlaneteType.php` (créé avec `php bin/console make:form`)

## API 'fait maison'

URL: `.../api-maison/planetes`

PHP: `src/Controller/ApiPlaneteController.php`

## Générateur de CRUD

`php bin/console make:crud`

URL: `.../planetes`

PHP: `src/Controller/PlaneteController.php`

## Admin automatique

[EasyAdmin](https://symfony.com/bundles/EasyAdminBundle/current/index.html)

`composer require easycorp/easyadmin-bundle`

URL: `.../admin`

PHP: `src/Controller/Admin/PlaneteCrudController.php`

## API automatique

[ApiPlateform](https://api-platform.com/docs/core/getting-started/)

`composer require api`

URL: `.../api`

annotation d'entité : `#[ApiResource]`
