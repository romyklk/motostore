<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Veuillez saisir le contenu')]
    #[Assert\Length(min: 10, max: 1000, minMessage: 'Le contenu doit contenir au moins {{ limit }} caractères', maxMessage: 'Le contenu doit contenir au maximum {{ limit }} caractères')]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez saisir le nom du client')]
    #[Assert\Length(min: 2, max: 100, minMessage: 'Le nom du client doit contenir au moins {{ limit }} caractères', maxMessage: 'Le nom du client doit contenir au maximum {{ limit }} caractères')]
    private ?string $clientName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: 'Veuillez sélectionner une date')]
    private ?\DateTimeInterface $reviewsDate = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez sélectionner une note')]
    private ?int $stars = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): static
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getReviewsDate(): ?\DateTimeInterface
    {
        return $this->reviewsDate;
    }

    public function setReviewsDate(\DateTimeInterface $reviewsDate): static
    {
        $this->reviewsDate = $reviewsDate;

        return $this;
    }

    public function getStars(): ?int
    {
        return $this->stars;
    }

    public function setStars(int $stars): static
    {
        $this->stars = $stars;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
