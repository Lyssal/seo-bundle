<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Entity\Traits;

use Lyssal\Seo\Model\Traits\PageTrait as SeoPageTrait;
use Lyssal\SeoBundle\Entity\Page;

/**
 * @see \Lyssal\Seo\Model\Traits\PageTrait
 */
trait PageTrait
{
    use SeoPageTrait;


    /**
     * @see \Lyssal\Seo\Model\Traits\PageTrait::getPage()
     */
    public function getPage(): ?Page
    {
        if (null !== $this->page) {
            $this->page->setEntity($this);
        }

        return $this->page;
    }

    /**
     * @see \Lyssal\Seo\Model\Traits\PageTrait::setPage()
     */
    public function setPage(?Page $page): self
    {
        if (null !== $page) {
            $page->setEntity($this);
        }
        $this->page = $page;

        return $this;
    }
}
