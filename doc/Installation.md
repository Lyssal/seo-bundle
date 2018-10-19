# Installation


* Install with Composer

```sh
composer require lyssal/seo-bundle
```

* Register manually the installed bundles in your kernel file if needed

* Overload the mapped super classes

* Updates the config parameters

All the `lyssal.seo.entity.*.class` parameters.
See the other parameters you can overload.

* Update your database

```sh
bin/console doctrine:schema:update --force
```

* Update your routes

For example:

```yaml
seo:
    resource: '@LyssalSeoBundle/Resources/config/routing.yaml'
```
