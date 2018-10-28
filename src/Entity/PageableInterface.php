<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Entity;

use Lyssal\Seo\Model\PageableInterface as SeoPageableInterface;

/**
 * {@inheritDoc}
 *
 * @method \Lyssal\SeoBundle\Entity\Page getPage()
 */
interface PageableInterface extends SeoPageableInterface
{
    /**
     * Get the ID.
     *
     * @return int The ID
     */
    public function getId();
}
