<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Slug;

use Doctrine\ORM\EntityManager;
use Lyssal\Entity\Appellation\AppellationManager;
use Lyssal\SeoBundle\Entity\Page;
use Lyssal\SeoBundle\Entity\PageableInterface;
use Lyssal\Text\Slug;
use Symfony\Component\Routing\RouterInterface;

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
     * @var \Symfony\Component\Routing\RouterInterface The router
     */
    protected $router;

    /**
     * @var \Lyssal\Entity\Appellation\AppellationManager The appellation manager
     */
    protected $appellationManager;

    /**
     * @var string The Page classname
     */
    protected $pageClassname;


    /**
     * SlugGenerator constructor.
     *
     * @param \Symfony\Component\Routing\RouterInterface    $router             The router
     * @param \Lyssal\Entity\Appellation\AppellationManager $appellationManager The appellation manager
     * @param string                                        $pageClassname      The Page classname
     */
    public function __construct(RouterInterface $router, AppellationManager $appellationManager, $pageClassname)
    {
        $this->router = $router;
        $this->appellationManager = $appellationManager;
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
     */
    public function generateForPageable(PageableInterface $pageable)
    {
        $slug = $this->getSlug($pageable->getPatternForSlug());
        $pageable->getPage()->setSlug($slug);

        $this->entityManager->persist($pageable);
        $this->entityManager->flush();
    }

    /**
     * Generate the page slug.
     *
     * @param \Lyssal\SeoBundle\Entity\Page $page The page
     */
    public function generateForPage(Page $page)
    {
        $slug = $this->getSlug($this->appellationManager->appellation($page));
        $page->setSlug($slug);

        $this->entityManager->persist($page);
        $this->entityManager->flush();
    }

    /**
     * Get an available slug.
     *
     * @param string $patternSlug The slug pattern
     *
     * @return string The generated slug
     */
    protected function getSlug(string $patternSlug): string
    {
        Slug::$MINIFICATION_ALLOWED_CHARACTERS .= '\/';
        $slug = new Slug(substr($patternSlug, 0, 768 - 4));
        $slug->minify('_', false);

        while (
            null !== $this->entityManager->getRepository($this->pageClassname)->findOneBy(['slug' => $slug->getText()])
            || $this->urlAlreadyExists('/'.$slug->getText())
        ) {
            $slug->next();
        }

        return $slug->getText();
    }

    /**
     * Return if the URL exists in an other route.
     *
     * @param string $url The URL
     *
     * @return bool If the URL exists
     */
    protected function urlAlreadyExists(string $url): bool
    {
        // We do not check dynamic URL with math() because It does not work with POST method (or other)
        $routeCollection = $this->router->getRouteCollection();
        /**
         * @var \Symfony\Component\Routing\Route $route
         */
        foreach ($routeCollection as $route) {
            if ($url === $route->getPath()) {
                return true;
            }
        }

        return false;
    }
}
