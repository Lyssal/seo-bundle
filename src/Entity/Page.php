<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Lyssal\EntityBundle\Entity\EntityableInterface;
use Lyssal\EntityBundle\Entity\RoutableInterface;
use Lyssal\EntityBundle\Entity\Traits\EntityTrait;
use Lyssal\Seo\Model\Page as LyssalPage;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritDoc}
 *
 * @ORM\MappedSuperclass(repositoryClass="Lyssal\SeoBundle\Repository\PageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Page extends LyssalPage implements EntityableInterface, RoutableInterface
{
    use EntityTrait;


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
     * @ORM\ManyToOne(targetEntity="Website", inversedBy="pages")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $website;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $online;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=768, nullable=true, unique=true)
     */
    protected $slug;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=2, nullable=true)
     *
     * @Assert\Length(min=2, max=2)
     */
    protected $locale;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $indexed;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $followed;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    protected $modificationFrequency;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="smallint", nullable=true)
     *
     * @Assert\Range(min=0, max=100)
     */
    protected $priority;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    protected $category;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $author;


    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * Init the last modification date.
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initUpdatedAt()
    {
        $this->updatedAt = new DateTime();
    }


    /**
     * @see \Lyssal\EntityBundle\Entity\RoutableInterface::getRouteProperties()
     */
    public function getRouteProperties(): array
    {
        return ['lyssal_seo_page_show', ['slug' => $this->slug]];
    }
}
