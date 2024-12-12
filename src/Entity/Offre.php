<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\Length(
        max: 20, 
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: '/^[A-Z]/', 
        message: "Le nom doit commencer par une lettre majuscule."
    )]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(max: 1000, maxMessage: "La description ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le type est obligatoire.")]
    #[Assert\Length(max: 255, maxMessage: "Le type ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\Type("\DateTimeInterface", message: "La date de lancement doit être une date valide.")]
    private ?\DateTimeInterface $dateLancement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\Type("\DateTimeInterface", message: "La date d'expiration doit être une date valide.")]
    #[Assert\GreaterThan(propertyPath: "dateLancement", message: "La date d'expiration doit être après la date de lancement.")] 
    private ?\DateTimeInterface $dateExpiration = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero(message: "Le prix original doit être un nombre positif ou égal à zéro.")]
    private ?float $prixOriginal = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero(message: "Le prix réduit doit être un nombre positif ou égal à zéro.")]
    private ?float $prixReduit = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(
        min: 0,
        max: 100,
        notInRangeMessage: "Le pourcentage de réduction doit être entre {{ min }}% et {{ max }}%."
    )]
    private ?float $pourcentageReduction = null;

    #[ORM\Column]
    private ?bool $statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDateLancement(): ?\DateTimeInterface
    {
        return $this->dateLancement;
    }

    public function setDateLancement(?\DateTimeInterface $dateLancement): static
    {
        $this->dateLancement = $dateLancement;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(?\DateTimeInterface $dateExpiration): static
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getPrixOriginal(): ?float
    {
        return $this->prixOriginal;
    }

    public function setPrixOriginal(?float $prixOriginal): static
    {
        $this->prixOriginal = $prixOriginal;

        return $this;
    }

    public function getPrixReduit(): ?float
    {
        return $this->prixReduit;
    }

    public function setPrixReduit(?float $prixReduit): static
    {
        $this->prixReduit = $prixReduit;

        return $this;
    }

    public function getPourcentageReduction(): ?float
    {
        return $this->pourcentageReduction;
    }

    public function setPourcentageReduction(?float $pourcentageReduction): static
    {
        $this->pourcentageReduction = $pourcentageReduction;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
 
       }

    public function setStatut(bool $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
