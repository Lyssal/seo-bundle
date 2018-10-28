<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Router;

use Lyssal\Entity\Decorator\DecoratorInterface;
use Lyssal\EntityBundle\Router\EntityRouter;
use Lyssal\SeoBundle\Entity\PageableInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * The entity router for pageable entities.
 */
class PageableRouter extends EntityRouter
{
    /**
     * @see \Lyssal\EntityBundle\Appellation\EntityRouterInterface::generate()
     */
    public function generate($entity, $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH): ?string
    {
        if (!($entity instanceof PageableInterface)) {
            if ($entity instanceof DecoratorInterface) {
                return $this->generate($entity->getEntity(), $parameters, $referenceType);
            }
            return null;
        }

        if (null !== $entity->getPage() && $entity->getPage()->isHomePage()) {
            return $this->router->generate('lyssal_seo_page_show', ['slug' => ''], $referenceType);
        }

        return parent::generate($entity->getPage(), $parameters, $referenceType);
    }
}
