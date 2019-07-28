<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Lyssal\SeoBundle\Entity\Page;

/**
 * The listener to automatically get entities from pages.
 */
class PageEntityGetter
{
    /**
     * @see \Lyssal\SeoBundle\EventListener\PageEntityGetter::initEntity()
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $this->initEntity($args);
    }

    /**
     * Set the entity.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args The arguments
     */
    protected function initEntity(LifecycleEventArgs $args): void
    {
        $page = $args->getEntity();

        if ($page instanceof Page && null === $page->getEntity() && null !== $page->getEntityClass() && null !== $page->getEntityId()) {
            $entityRepository = $args->getEntityManager()->getRepository($page->getEntityClass());

            $page->setEntity($entityRepository->find($page->getEntityId()));
        }
    }
}
