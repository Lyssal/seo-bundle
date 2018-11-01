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
use Lyssal\SeoBundle\Entity\PageableInterface;

/**
 * The listener to generate entity in the pageable entities.
 */
class PageEntitySetter
{
    /**
     * @see \Lyssal\SeoBundle\EventListener\PageEntitySetter::setEntity()
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->setEntity($args);
    }

    /**
     * @see \Lyssal\SeoBundle\EventListener\PageEntitySetter::setEntity()
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->setEntity($args);
    }

    /**
     * Set the entity.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args The arguments
     */
    protected function setEntity(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof PageableInterface) {
            $this->setPageableEntity($entity, $args);
        }

        if ($entity instanceof Page && $entity->getEntity() instanceof PageableInterface) {
            $this->setPageableEntity($entity->getEntity(), $args);
        }
    }

    /**
     * Set the pageable entity.
     *
     * @param \Lyssal\SeoBundle\Entity\PageableInterface $pageable The pageable
     * @param \Doctrine\ORM\Event\LifecycleEventArgs     $args     The arguments
     */
    protected function setPageableEntity(PageableInterface $pageable, LifecycleEventArgs $args): void
    {
        $page = $pageable->getPage();

        if (!$page->isIndependent()) {
            $pageableClass = get_class($pageable);
            if ($pageableClass !== $page->getEntityClass() && $pageable->getId() !== $page->getEntityId()) {
                $page->setEntityClass($pageableClass);
                $page->setEntityId($pageable->getId());

                $args->getEntityManager()->persist($page);
                $args->getEntityManager()->flush();
            }
        }
    }
}
