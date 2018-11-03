<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Controller;

use Lyssal\SeoBundle\Host\CurrentHost;
use Lyssal\SeoBundle\Sitemap\SitemapGenerator;
use Lyssal\SeoBundle\Website\CurrentWebsite;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The sitemap controller.
 *
 * @Route("/", name="lyssal_seo_sitemap_")
 */
class SitemapController extends AbstractController
{
    /**
     * The sitemap.xml.
     *
     * @Route("/sitemap.xml", name="xml", methods={"GET"})
     */
    public function xml(Request $request)
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

        $domain = $this->container->get(CurrentHost::class)->getDomain($request);
        $sitemap = $this->container->get(SitemapGenerator::class)->generate($website, $domain);

        return new Response($sitemap, Response::HTTP_OK, [
            'Content-Type' => 'application/xml'
        ]);
    }
}
