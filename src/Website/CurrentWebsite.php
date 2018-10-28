<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Website;

use Lyssal\SeoBundle\Entity\Host;
use Lyssal\SeoBundle\Entity\Website;
use Lyssal\SeoBundle\Host\CurrentHost;
use Lyssal\SeoBundle\Manager\WebsiteManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Service to get the current website.
 */
class CurrentWebsite
{
    /**
     * @var \Lyssal\SeoBundle\Host\CurrentHost The current host service
     */
    protected $currentHost;

    /**
     * @var \Lyssal\SeoBundle\Manager\WebsiteManager The Website manager
     */
    protected $websiteManager;


    /**
     * CurrentWebsite constructor.
     *
     * @param \Lyssal\SeoBundle\Manager\WebsiteManager $websiteManager The Website manager
     * @param \Lyssal\SeoBundle\Host\CurrentHost       $currentHost    The current host service
     */
    public function __construct(CurrentHost $currentHost, WebsiteManager $websiteManager)
    {
        $this->currentHost = $currentHost;
        $this->websiteManager = $websiteManager;
    }


    /**
     * Get the current website.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     *
     * @return \Lyssal\SeoBundle\Entity\Website|null The current website
     */
    public function get(Request $request): ?Website
    {
        $host = $this->currentHost->get($request);

        return $this->getByHost($host);
    }

    /**
     * Get the current website by host.
     *
     * @param \Lyssal\SeoBundle\Entity\Host|null $host The host
     *
     * @return \Lyssal\SeoBundle\Entity\Website|null The current website
     */
    public function getByHost(?Host $host)
    {
        if (null !== $host) {
            return $host->getWebsite();
        }

        return $this->websiteManager->findOneBy(['byDefault' => true]);
    }
}
