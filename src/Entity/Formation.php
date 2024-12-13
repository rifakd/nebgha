<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'the name cannot be blank')]
    #[Assert\NotNull(message:'the name cannot be null')]
    #[Assert\Regex(pattern: '/^[a-zA-Z_\s]{4,}$/', message: 'The cours name can only contain letters and numbers.' )]  
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date de début ne peut pas être vide.')]
    #[Assert\GreaterThan(value: 'today',message: 'La date de début doit être une date future.' )]
        private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'the name cannot be blank')]
    #[Assert\NotNull(message:'the name cannot be null')]
    #[Assert\Regex(
        pattern: '/^\d+\s*(heures|jours|semaines|mois|années)?$/i',
        message: "La durée doit être formulée comme 'nheures, njours', 'nsemaines', etc."
    )]
    private ?string $Duree = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'the description cannot be blank')]
    #[Assert\NotNull(message:'the description cannot be null')]
    #[Assert\Type(type:'String',message:'the name must be a string')]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type('float')]
    #[Assert\GreaterThan(0)]
    private ?float $cout = null;

    /**
     * @var Collection<int, Devoir>
     */
    #[ORM\OneToMany(targetEntity: Devoir::class, mappedBy: 'id_formation')]
    private Collection $devoirs;

    /**
     * @var Collection<int, Etudiant>
     */
    #[ORM\ManyToMany(targetEntity: Etudiant::class, inversedBy: 'formations')]
    private Collection $etudiants;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?Professeur $id_prof = null;

    public function __construct()
    {
        $this->devoirs = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
    }

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->Duree;
    }

    public function setDuree(string $Duree): static
    {
        $this->Duree = $Duree;

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

    public function getCout(): ?float
    {
        return $this->cout;
    }

    public function setCout(float $cout): static
    {
        $this->cout = $cout;

        return $this;
    }

    /**
     * @return Collection<int, Devoir>
     */
    public function getDevoirs(): Collection
    {
        return $this->devoirs;
    }

    public function addDevoir(Devoir $devoir): static
    {
        if (!$this->devoirs->contains($devoir)) {
            $this->devoirs->add($devoir);
            $devoir->setIdFormation($this);
        }

        return $this;
    }

    public function removeDevoir(Devoir $devoir): static
    {
        if ($this->devoirs->removeElement($devoir)) {
            // set the owning side to null (unless already changed)
            if ($devoir->getIdFormation() === $this) {
                $devoir->setIdFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): static
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants->add($etudiant);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): static
    {
        $this->etudiants->removeElement($etudiant);

        return $this;
    }

    public function getIdProf(): ?Professeur
    {
        return $this->id_prof;
    }

    public function setIdProf(?Professeur $id_prof): static
    {
        $this->id_prof = $id_prof;

        return $this;
    }
}
