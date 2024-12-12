<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    #[Assert\Length(max: 255, maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(max: 1000, maxMessage: "La description ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $description = null;

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank(message: "Le type est obligatoire.")]
    #[Assert\Choice(choices: ['Séminaire', 'Webinaire', 'Atelier', 'Conférence'], message: "Le type doit être valide.")]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: "La date de début est obligatoire.")]
    #[Assert\Type("\DateTimeInterface", message: "La date de début doit être une date valide.")]  
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\Type("\DateTimeInterface", message: "La date de fin doit être une date valide.")]
    #[Assert\GreaterThanOrEqual(propertyPath: "dateDebut", message: "La date de fin doit être après ou égale à la date de début.")]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: "Le lieu ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $lieu = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type("integer", message: "La capacité doit être un entier.")]
    #[Assert\Range(min: 0, minMessage: "La capacité doit être un nombre positif.")]
    private ?int $capacite = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le statut est obligatoire.")]
    private ?bool $statut = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(min: 0, minMessage: "Les frais de participation doivent être positifs.")]
    private ?float $fraisParticipation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(max: 1000, maxMessage: "La liste des tags ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $tags = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(?int $capacite): static
    {
        $this->capacite = $capacite;

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

    public function getFraisParticipation(): ?float
    {
        return $this->fraisParticipation;
    }

    public function setFraisParticipation(?float $fraisParticipation): static
    {
        $this->fraisParticipation = $fraisParticipation;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): static
    {
            if ($tags) {
                // On sépare les tags par des virgules
                $tagsArray = explode(',', $tags);
        
                // On s'assure que chaque tag commence par #
                $tagsArray = array_map(function ($tag) {
                    $tag = trim($tag); // Retirer les espaces autour du tag
                    // On ajoute # uniquement si le tag ne commence pas déjà par #
                    if (substr($tag, 0, 1) !== '#') {
                        $tag = '#' . $tag; // Ajouter # au début si ce n'est pas déjà le cas
                    }
                    return $tag;
                }, $tagsArray);
        
                // Rejoindre les tags formatés en une chaîne de texte, sans ajouter de # supplémentaire
                $this->tags = implode(',', $tagsArray);
            } else {
                $this->tags = null; // Si tags est vide, on le met à null
            }
        
            return $this;
        }
        
}
