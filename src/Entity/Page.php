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
use Lyssal\EntityBundle\Entity\Traits\EntityTrait;
use Lyssal\Seo\Model\Page as LyssalPage;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritDoc}
 *
 * @ORM\MappedSuperclass(repositoryClass="Lyssal\SeoBundle\Repository\PageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Page extends LyssalPage implements EntityableInterface
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
     *
     * @Assert\Length(max=255)
     */
    protected $title;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=768, nullable=true, unique=true)
     *
     * @Assert\Length(max=768)
     */
    protected $slug;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(max=255)
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
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * {@inheritDoc}
     *
     * @ORM\Column(type="datetime", nullable=false)
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
     *
     * @Assert\Length(max=255)
     */
    protected $author;

    /**
     * @var bool If the page is not linked to an entity
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default"=false})
     */
    protected $independent;

    /**
     * @var string The content which can be use an introduction or content if the page is independent
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;


    /**
     * Page constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->independent = false;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIndependent(): bool
    {
        return $this->independent;
    }

    public function setIndependent(bool $independent): self
    {
        $this->independent = $independent;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }


    /**
     * Init the creation date.
     *
     * @ORM\PrePersist()
     */
    public function initCreatedAt()
    {
        $this->createdAt = new DateTime();
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
}
