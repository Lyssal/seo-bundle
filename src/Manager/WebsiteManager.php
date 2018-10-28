<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Manager;

use Lyssal\Doctrine\Orm\Manager\EntityManager;
use Lyssal\Doctrine\Orm\QueryBuilder;
use Lyssal\SeoBundle\Entity\Website;

/**
 * @inheritDoc
 */
class WebsiteManager extends EntityManager
{
    /**
     * Get website by its domain.
     *
     * @param string $domain The domain
     *
     * @return \Lyssal\SeoBundle\Entity\Website The website
     */
    public function findOneByDomain(string $domain): ?Website
    {
        return $this->findOneBy(
            [
                'host.domain' => $domain
            ],
            [],
            [
                QueryBuilder::INNER_JOINS => ['hosts' => 'host']
            ]
        );
    }
}
