# Installation


* Install with Composer

```sh
composer require lyssal/seo-bundle
```

* Register manually the installed bundles in your kernel file if needed

* Overload the mapped super classes :

Entities are `Host`, `Website` and `Page`.

For example the `Page` entity:

```php
namespace App\Entity\Seo;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\SeoBundle\Entity\Page as LyssalPage;

/**
 * @inheritDoc
 *
 * @ORM\Entity()
 */
class Page extends LyssalPage
{
    // Add your custom properties / methods here
}
```

* Updates the config parameters:

All the `lyssal.seo.entity.*.class` parameters.

For example:

```yaml
parameters:
    lyssal.seo.entity.host.class: 'App\Entity\Seo\Host'
    lyssal.seo.entity.page.class: 'App\Entity\Seo\Page'
    lyssal.seo.entity.website.class: 'App\Entity\Seo\Website'
```

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
