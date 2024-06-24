<?php

namespace App\Entity;

use App\Repository\GeneralSettingsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GeneralSettingsRepository::class)]
class GeneralSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 100, minMessage: 'Le nom du site doit contenir au moins 2 caractères', maxMessage: 'Le nom du site doit contenir au maximum 100 caractères')]
    private ?string $siteName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $siteLogo = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 8, max: 20, minMessage: 'Le numéro de téléphone doit contenir au moins 8 caractères', maxMessage: 'Le numéro de téléphone doit contenir au maximum 20 caractères')]
    private ?string $siteTel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fbLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $whatsappLink = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email(message: 'Veuillez saisir une adresse email valide')]
    private ?string $siteEmail = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 150, minMessage: 'L\'adresse doit contenir au moins 2 caractères', maxMessage: 'L\'adresse doit contenir au maximum 255 caractères')]
    private ?string $siteAddress = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(string $siteName): static
    {
        $this->siteName = $siteName;

        return $this;
    }

    public function getSiteLogo(): ?string
    {
        return $this->siteLogo;
    }

    public function setSiteLogo(string $siteLogo): static
    {
        $this->siteLogo = $siteLogo;

        return $this;
    }

    public function getSiteTel(): ?string
    {
        return $this->siteTel;
    }

    public function setSiteTel(string $siteTel): static
    {
        $this->siteTel = $siteTel;

        return $this;
    }

    public function getFbLink(): ?string
    {
        return $this->fbLink;
    }

    public function setFbLink(?string $fbLink): static
    {
        $this->fbLink = $fbLink;

        return $this;
    }

    public function getWhatsappLink(): ?string
    {
        return $this->whatsappLink;
    }

    public function setWhatsappLink(?string $whatsappLink): static
    {
        $this->whatsappLink = $whatsappLink;

        return $this;
    }

 

    public function getSiteEmail(): ?string
    {
        return $this->siteEmail;
    }

    public function setSiteEmail(string $siteEmail): static
    {
        $this->siteEmail = $siteEmail;

        return $this;
    }

    public function getSiteAddress(): ?string
    {
        return $this->siteAddress;
    }

    public function setSiteAddress(string $siteAddress): static
    {
        $this->siteAddress = $siteAddress;

        return $this;
    }
}
