<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Lyssal\SeoBundle\Entity\PageableInterface;
use Lyssal\SeoBundle\Slug\SlugGenerator;

/**
 * The listener to generate slug on pages.
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
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->generateSlugIfNeed($args);
    }

    /**
     * @see \Lyssal\SeoBundle\EventListener\PageSlugger::generateSlugIfNeed()
     */
    public function preUpdate(LifecycleEventArgs $args)
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
        $pageable = $args->getEntity();

        if (!($pageable instanceof PageableInterface)) {
            return;
        }

        if ($pageable->canGenerateSlug()) {
            $this->slugGenerator->setEntityManager($args->getEntityManager());
            $this->slugGenerator->generate($pageable);
        }
    }
}
