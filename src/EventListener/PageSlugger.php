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
     * @see \Lyssal\SeoBundle\EventListener\PageSlugger::generateSlugIfNeed()
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->generateSlugIfNeed($args);
    }

    /**
     * @see \Lyssal\SeoBundle\EventListener\PageSlugger::generateSlugIfNeed()
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->generateSlugIfNeed($args);
    }

    /**
     * Generate the slug if needed.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args The arguments
     */
    protected function generateSlugIfNeed(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof PageableInterface) {
            $this->generateSlugForPageableIfNeed($entity, $args);
        }

        if ($entity instanceof Page && $entity->getEntity() instanceof PageableInterface) {
            $this->generateSlugForPageableIfNeed($entity->getEntity(), $args);
        }
    }

    /**
     * Generate the slug for the pageable if needed.
     *
     * @param \Lyssal\SeoBundle\Entity\PageableInterface $pageable The pageable
     * @param \Doctrine\ORM\Event\LifecycleEventArgs     $args     The arguments
     */
    protected function generateSlugForPageableIfNeed(PageableInterface $pageable, LifecycleEventArgs $args): void
    {
        if ($pageable->canGenerateSlug()) {
            $this->slugGenerator->setEntityManager($args->getEntityManager());
            $this->slugGenerator->generate($pageable);
        }
    }
}
