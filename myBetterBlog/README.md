# MyBetterBlug

Utilisation du bundle EadyAdmin

https://symfony.com/doc/4.x/EasyAdminBundle/index.html

Installation

```
composer require easycorp/easyadmin-bundle
```

Création "Dashboard" (configuration générale + menu)

```
php bin/console make:admin:dashboard
```

Création "CRUD" (Gestion d'un type d'entité)

```
php bin/console make:admin:crud
```

Trucs à voir 

- [ ] Couche sécurité
- [ ] "hack" localhost
- [ ] Text editor
- [ ] Rôles
- [ ] Gestion password (plainPassword / EventSubscriber)
- [ ] Traduction
