<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Host;

use Lyssal\SeoBundle\Entity\Host;
use Lyssal\SeoBundle\Doctrine\Administrator\HostAdministrator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Service to get the current host.
 */
class CurrentHost
{
    /**
     * @var \Lyssal\SeoBundle\Doctrine\Administrator\HostAdministrator The Host manager
     */
    protected $hostManager;


    /**
     * CurrentHost constructor.
     *
     * @param \Lyssal\SeoBundle\Doctrine\Administrator\HostAdministrator $hostManager The Host manager
     */
    public function __construct(HostAdministrator $hostManager)
    {
        $this->hostManager = $hostManager;
    }


    /**
     * Get the current host.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     *
     * @return \Lyssal\SeoBundle\Entity\Host|null The current host
     */
    public function get(Request $request): ?Host
    {
        return $this->hostManager->findOneBy(['domain' => $this->getDomain($request)]);
    }

    /**
     * @see \Symfony\Component\HttpFoundation\Request::getSchemeAndHttpHost()
     */
    public function getDomain(Request $request): string
    {
        return $request->getSchemeAndHttpHost();
    }
}
