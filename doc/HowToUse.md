# How to use

## To do

### Update your pageable entities

Your class has to implement these two interfaces:

* `Lyssal\SeoBundle\Entity\PageableInterface`
* `Lyssal\EntityBundle\Entity\ControllerableInterface`

The Pageable interface means your entity will have a Page perperty.
You can use the trait `Lyssal\SeoBundle\Entity\Traits\PageTrait` to define the Pageable methods by default.

The Routable interface means a route is linked to your entity (else to have a Page would be useless).


### Create a Website

Before use the Pageable interface, make sure you have at least one website in database.

If you have many websites to manage, create hosts else you can only set Website.byDefault at true.

Read the property phpdoc in entities to know more.


## Example

```php
namespace App\Entity;

use App\Controller\MyPageableEntityController;
use Lyssal\EntityBundle\Entity\ControllerableInterface;
use Lyssal\SeoBundle\Entity\PageableInterface;
use Lyssal\SeoBundle\Entity\Traits\PageTrait;

/**
 * My pageable entity.
 */
class MyPageableEntity implements PageableInterface, ControllerableInterface
{
    use PageTrait;


    // My properties and methods
    

    /**
     * @see \Lyssal\Seo\Model\PageableInterface::getPatternForSlug()
     */
    public function getPatternForSlug()
    {
        return 'SpecificSlugForThisEntity/'.$this->page->getTitle();
    }

    /**
     * \Lyssal\EntityBundle\Entity\ControllerableInterface::getControllerProperties()
     */
    public function getControllerProperties(): array
    {
        return [MyPageableEntityController::class.'::show', ['my_pageable_entity' => $this->id]];
    }
}
```
