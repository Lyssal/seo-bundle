<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Manager;

use Lyssal\Doctrine\Orm\Manager\EntityManager;
use Lyssal\SeoBundle\Entity\Page;

/**
 * @inheritDoc
 */
class PageManager extends EntityManager
{
    /**
     * Get the linked entity.
     *
     * @param \Lyssal\SeoBundle\Entity\Page $page The page
     *
     * @return object|null The entity
     */
    public function getEntity(Page $page)
    {
        if (null === $page->getEntityClass() || null === $page->getEntityId()) {
            return null;
        }

        $entityRepository = $this->entityManager->getRepository($page->getEntityClass());

        return $entityRepository->find($page->getEntityId());
    }
}
