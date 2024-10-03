<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\SeoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\Seo\Model\Host as LyssalHost;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritDoc}
 *
 * @ORM\MappedSuperclass(repositoryClass="Lyssal\SeoBundle\Repository\HostRepository")
 */
class Host extends LyssalHost
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
     *
     * @Assert\Url()
     */
    protected $domain;

    protected $website;

    /**
     * @var \Lyssal\SeoBundle\Entity\Host The redirection host
     */
    protected $redirectionHost;

    /**
     * @var int The redirection code
     *
     * @ORM\Column(type="smallint", length=3, nullable=true)
     */
    protected $redirectionCode;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRedirectionHost(): ?self
    {
        return $this->redirectionHost;
    }

    public function setRedirectionHost(?self $redirectionHost): self
    {
        $this->redirectionHost = $redirectionHost;

        return $this;
    }

    public function getRedirectionCode(): ?int
    {
        return $this->redirectionCode;
    }

    public function setRedirectionCode(?int $redirectionCode): self
    {
        $this->redirectionCode = $redirectionCode;

        return $this;
    }
}
