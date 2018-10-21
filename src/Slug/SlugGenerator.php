<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Slug;

use Doctrine\ORM\EntityManager;
use Lyssal\SeoBundle\Entity\PageableInterface;
use Lyssal\SeoBundle\Manager\PageManager;
use Lyssal\Text\Slug;

/**
 * The slug generator.
 */
class SlugGenerator
{
    /**
     * @var string The slug separator
     */
    public static $SEPARATOR = '-';


    /**
     * @var \Doctrine\ORM\EntityManager The page manager
     */
    protected $entityManager;

    /**
     * @var string The Page classname
     */
    protected $pageClassname;


    /**
     * SlugGenerator constructor.
     *
     * @param string $pageClassname The Page classname
     */
    public function __construct($pageClassname)
    {
        $this->pageClassname = $pageClassname;
    }

    /**
     * Set the entity manager.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager The page manager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * Generate the page slug.
     *
     * @param \Lyssal\SeoBundle\Entity\PageableInterface $pageable The pageable
     *
     * @return string The slug
     */
    public function generate(PageableInterface $pageable): void
    {
        Slug::$MINIFICATION_ALLOWED_CHARACTERS .= '\/';
        $slug = new Slug(substr($pageable->getPatternForSlug(), 0, 768 - 4));
        $slug->minify();

        while (null !== $this->entityManager->getRepository($this->pageClassname)->findOneBy(['slug' => $slug->getText()])) {
            $slug->next();
        }

        $pageable->getPage()->setSlug($slug->getText());
        $this->entityManager->persist($pageable);
        $this->entityManager->flush();
    }
}
