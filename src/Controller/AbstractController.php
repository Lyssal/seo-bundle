<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Controller;

use Lyssal\SeoBundle\Entity\Host;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The SEO parent controller.
 */
class AbstractController extends SymfonyAbstractController
{
    /**
     * Verify if we are in the good host.
     * We do not verify if the host is present in database because there can be a default website.
     *
     * @param \Lyssal\SeoBundle\Entity\Host             $host    The host
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|null The response if not the good host
     */
    protected function verifyHost(?Host $host, Request $request): ?RedirectResponse
    {
        if (null !== $host) {
            if (null !== $host->getRedirectionHost()) {
                $redirectionCode = $host->getRedirectionCode() ?: Response::HTTP_FOUND;
                return $this->redirect($host->getRedirectionHost()->getDomain().$request->getRequestUri(), $redirectionCode);
            }
        }

        return null;
    }
}
