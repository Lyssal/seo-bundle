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
use Lyssal\SeoBundle\Slug\SlugGenerator;

/**
 * The listener to generate slug on pages.
 *
 * We use post events because if we clear the slug and regenerate, if the slug is same a -# will be added at the end of the slug.
 */
class PageSlugger
{
    /**
     * @var \Lyssal\SeoBundle\Slug\SlugGenerator The slug generator
     */
    protected $slugGenerator;


    /**
     * PageSlugger constructor.
     *
     * @param \Lyssal\SeoBundle\Slug\SlugGenerator $slugGenerator The slug generator
     */
    public function __construct(SlugGenerator $slugGenerator)
    {
        $this->slugGenerator = $slugGenerator;
    }


    /**
     * @see \Lyssal\SeoBundle\EventListener\PageSlugger::generateSlugIfNeeded()
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->generateSlugIfNeeded($args);
    }

    /**
     * @see \Lyssal\SeoBundle\EventListener\PageSlugger::generateSlugIfNeeded()
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->generateSlugIfNeeded($args);
    }

    /**
     * Generate the slug if needed.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args The arguments
     */
    protected function generateSlugIfNeeded(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof PageableInterface) {
            $this->generateSlugForPageableIfNeeded($entity, $args);
        }

        if ($entity instanceof Page) {
            if ($entity->getEntity() instanceof PageableInterface) {
                $this->generateSlugForPageableIfNeeded($entity->getEntity(), $args);
            } else {
                $this->generateSlugForPageIfNeeded($entity, $args);
            }
        }
    }

    /**
     * Generate the slug for the pageable if needed.
     *
     * @param \Lyssal\SeoBundle\Entity\PageableInterface $pageable The pageable
     * @param \Doctrine\ORM\Event\LifecycleEventArgs     $args     The arguments
     */
    protected function generateSlugForPageableIfNeeded(PageableInterface $pageable, LifecycleEventArgs $args): void
    {
        if ($pageable->canGenerateSlug()) {
            $this->slugGenerator->setEntityManager($args->getEntityManager());
            $this->slugGenerator->generateForPageable($pageable);
        }
    }

    /**
     * Generate the slug for the page if needed.
     *
     * @param \Lyssal\SeoBundle\Entity\Page          $page The page
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args The arguments
     */
    protected function generateSlugForPageIfNeeded(Page $page, LifecycleEventArgs $args): void
    {
        if (null === $page->getSlug() && $page->isIndependent()) {
            $this->slugGenerator->setEntityManager($args->getEntityManager());
            $this->slugGenerator->generateForPage($page);
        }
    }
}
