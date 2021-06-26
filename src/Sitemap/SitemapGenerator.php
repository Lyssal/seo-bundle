<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Sitemap;

use Lyssal\SeoBundle\Entity\Page;
use Lyssal\SeoBundle\Entity\Website;
use Lyssal\SeoBundle\Doctrine\Administrator\PageAdministrator;
use Thepixeldeveloper\Sitemap\Drivers\XmlWriterDriver;
use Thepixeldeveloper\Sitemap\Url;
use Thepixeldeveloper\Sitemap\Urlset;

/**
 * Generate a sitemap.xml.
 */
class SitemapGenerator
{
    /**
     * @var \Lyssal\SeoBundle\Doctrine\Administrator\PageAdministrator The page manager
     */
    protected $pageManager;


    /**
     * SitemapGenerator constructor.
     *
     * @param \Lyssal\SeoBundle\Doctrine\Administrator\PageAdministrator $pageManager The page manager
     */
    public function __construct(PageAdministrator $pageManager)
    {
        $this->pageManager = $pageManager;
    }


    /**
     * Generate the sitemap.xml.
     *
     * @param \Lyssal\SeoBundle\Entity\Website $website The website
     * @param string                           $domain  The domain
     *
     * @return string The sitemap.xml content
     */
    public function generate(Website $website, string $domain): string
    {
        $urlset = new Urlset();

        foreach ($this->getUrls($website, $domain) as $url) {
            $urlset->add($url);
        }

        $driver = new XmlWriterDriver();
        $urlset->accept($driver);

        return $driver->output();
    }

    /**
     * Get the URLs.
     *
     * @param \Lyssal\SeoBundle\Entity\Website $website The website
     * @param string                           $domain  The domain
     *
     * @return \Thepixeldeveloper\Sitemap\Url[] The URLs
     */
    protected function getUrls(Website $website, string $domain): array
    {
        $urls = [];
        $pages = $this->pageManager->getForSitemap($website);

        foreach ($pages as $page) {
            $urls[] = $this->getUrl($page, $domain);
        }

        return $urls;
    }

    /**
     * Get a sitemap URL.
     *
     * @param \Lyssal\SeoBundle\Entity\Page $page   The page
     * @param string                        $domain The domain
     *
     * @return \Thepixeldeveloper\Sitemap\Url The URL
     */
    protected function getUrl(Page $page, string $domain): Url
    {
        $url = new Url($domain.'/'.$page->getSlug());

        $url->setLastMod($page->getUpdatedAt());
        if (null !== $page->getModificationFrequency()) {
            $url->setChangeFreq($page->getModificationFrequency());
        }
        if (null !== $page->getPriority()) {
            $url->setPriority($page->getPriority());
        }

        return $url;
    }
}
