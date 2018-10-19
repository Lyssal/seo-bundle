<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Lyssal\Seo\Model\Website as LyssalWebsite;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritDoc}
 *
 * @ORM\MappedSuperclass(repositoryClass="Lyssal\SeoBundle\Repository\WebsiteRepository")
 */
class Website extends LyssalWebsite
{
    /**
     * @var int The ID
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\Url()
     */
    protected $domain;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $author;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $publisher;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $copyright;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $generator;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Email()
     */
    protected $replyTo;

    /**
     * @var \Doctrine\Common\Collections\Collection The pages
     *
     * @ORM\OneToMany(targetEntity="Page", mappedBy="website")
     */
    protected $pages;


    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }


    /**
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setWebsite($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
            // set the owning side to null (unless already changed)
            if ($page->getWebsite() === $this) {
                $page->setWebsite(null);
            }
        }

        return $this;
    }
}
