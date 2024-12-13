<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'The name cannot be blank')]
    #[Assert\NotNull(message: 'The name cannot be null')]
    #[Assert\Length(max: 80, maxMessage: 'cours name cannot exceed {{ limit }} characters.')]
    #[Assert\Length(
        min: 5,
        max: 100,
        minMessage: 'The cours name must be at least {{ limit }} characters long.',
        maxMessage: 'The cours name cannot exceed {{ limit }} characters.'
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\s\-\'&,.()\/]{4,}$/u',
        message: 'The course name must be at least 4 characters and can contain letters, numbers, spaces, hyphens, apostrophes, ampersands, dots, commas and parentheses.'
    )] 
    private ?string $nom;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank(message: 'The date of creation cannot be blank')]
    #[Assert\NotNull(message: 'The date of creation cannot be null')]
    //#[Assert\LessThanOrEqual(value: 'today', message: 'The date of creation cannot be in the future')]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'The description cannot be blank')]
    #[Assert\NotNull(message: 'The description cannot be null')]
    #[Assert\Length(max: 1000, maxMessage: 'The description cannot exceed {{ limit }} characters.')]
    private ?string $description;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'The duree cannot be blank')]
    #[Assert\NotNull(message: 'The duree cannot be null')]
    #[Assert\Regex(
        pattern: '/^\d+\s*(heures|jours|semaines|mois|années)?$/i',
        message: "La durée doit être formulée comme '2heures', '4heures', etc."
    )]
    private ?string $duree;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'The date is required')]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\LessThanOrEqual('today', message: 'The date cannot be in the future')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'The heure cannot be blank')]
    #[Assert\NotNull(message: 'The heure cannot be null')]
    #[Assert\GreaterThanOrEqual('09:00', message: 'Start time must be after or at 9 AM')]
    #[Assert\LessThanOrEqual('16:00', message: 'Start time must be before or at 4 PM')]
    private \DateTimeInterface $heureDebut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(?\DateTimeInterface $heureDebut): static
    {
        if ($heureDebut) {
            $today = new \DateTime();
            $heureDebut->setDate($today->format('Y'), $today->format('m'), $today->format('d'));
        }
        $this->heureDebut = $heureDebut;
        return $this;
    }

}
