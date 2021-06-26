<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Controller;

use Lyssal\EntityBundle\Entity\ControllerableInterface;
use Lyssal\SeoBundle\Host\CurrentHost;
use Lyssal\SeoBundle\Website\CurrentWebsite;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The page controller.
 *
 * @Route("/", name="lyssal_seo_page_")
 */
class PageController extends AbstractController
{
    /**
     * Show a page.
     *
     * @Route("/{slug}", name="show", requirements={"slug"=".*"}, methods={"GET"})
     */
    public function show(Request $request, $slug)
    {
        $host = $this->container->get(CurrentHost::class)->get($request);
        $hostRedirection = $this->verifyHost($host, $request);
        if (null !== $hostRedirection) {
            return $hostRedirection;
        }

        $website = $this->container->get(CurrentWebsite::class)->get($request);
        if (null === $website) {
            throw $this->createNotFoundException('The website has not been found.');
        }

        /**
         * @var \Lyssal\SeoBundle\Entity\Page $page
         */
        if ('' === $slug && null !== $website->getHomePage()) {
            $page = $website->getHomePage();
        } else {
            $page = $this->container->get('lyssal.seo.administrator.page')->findOneBy(['website' => $website, 'slug' => $slug]);
        }

        if (null === $page) {
            throw $this->createNotFoundException('The page has not been found. Maybe the slug is wrong or you have to change the order of calls in the routing file.');
        }

        if ($page->isIndependent()) {
            return $this->render('@LyssalSeo/page/show.html.twig', ['page' => $page]);
        }

        $entity = $this->container->get('lyssal.seo.administrator.page')->getEntity($page);
        if (null === $entity) {
            throw $this->createNotFoundException('The entity for the page with the slug '.$slug.' has not been found.');
        }

        if (!($entity instanceof ControllerableInterface)) {
            $this->createNotFoundException('To show the page, the entity class '.get_class($entity).' has to implements ControllerableInterface.');
        }

        $controllerProperties = $entity->getControllerProperties();
        $actionParameters = [];
        if (is_string($controllerProperties)) {
            $actionName = $controllerProperties;
        } elseif (is_array($controllerProperties) && count($controllerProperties) > 0) {
            $actionName = $controllerProperties[0];
            if (count($controllerProperties) > 1) {
                if (!is_array($controllerProperties[1])) {
                    throw new InvalidArgumentException('The second cell of the returned array in getControllerProperties() has to be an array with the action parameters.');
                }
                $actionParameters = $controllerProperties[1];
            }
        } else {
            throw new InvalidArgumentException('The getControllerProperties() method must returned at least the action name.');
        }

        // Add the added query parameters
        $actionParameters = array_merge($request->query->all(), $actionParameters);

        return $this->forward($actionName, $actionParameters);
    }
}
