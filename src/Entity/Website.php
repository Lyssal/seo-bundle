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
     * @ORM\ManyToOne(targetEntity="Page")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $homePage;

    /**
     * @var bool If It is the website by default
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default"=false})
     */
    protected $byDefault;

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

    /**
     * @var \Doctrine\Common\Collections\Collection The hosts
     *
     * @ORM\OneToMany(targetEntity="Host", mappedBy="website", cascade={"persist"}, orphanRemoval=true)
     */
    protected $hosts;


    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->hosts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function isByDefault(): ?bool
    {
        return $this->byDefault;
    }

    public function setByDefault(bool $byDefault): self
    {
        $this->byDefault = $byDefault;

        return $this;
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

    /**
     * @return Collection|Host[]
     */
    public function getHosts(): Collection
    {
        return $this->hosts;
    }

    public function addHost(Host $host): self
    {
        if (!$this->hosts->contains($host)) {
            $this->hosts[] = $host;
            $host->setWebsite($this);
        }

        return $this;
    }

    public function removeHost(Host $host): self
    {
        if ($this->hosts->contains($host)) {
            $this->hosts->removeElement($host);
            // set the owning side to null (unless already changed)
            if ($host->getWebsite() === $this) {
                $host->setWebsite(null);
            }
        }

        return $this;
    }
}
