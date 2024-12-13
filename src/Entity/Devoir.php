<?php

namespace App\Entity;

use App\Repository\DevoirRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DevoirRepository::class)]
class Devoir
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'The name cannot be blank ')]
    #[Assert\NotNull(message: 'The name cannot be null')]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'The heureDebut cannot be blank')]
    #[Assert\NotNull(message: 'The heureDebut cannot be null')]
    #[Assert\GreaterThanOrEqual('09:00', message: 'Start time must be after or at 9 AM')]
    #[Assert\LessThanOrEqual('16:00', message: 'Start time must be before or at 4 PM')]
    private ?\DateTimeInterface $heureDebut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'heureFin cannot be blank')]
    #[Assert\NotNull(message: 'heureFin cannot be null')]
    #[Assert\GreaterThanOrEqual('09:00', message: 'End time must be after or at 9 AM')]
    #[Assert\LessThanOrEqual('16:00', message: 'End time must be before or at 4 PM')]
    #[Assert\Expression(
        "this.getHeureFin() > this.getHeureDebut()",
        message: 'End time must be after start time'
    )]
    private ?\DateTimeInterface $heureFin = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'The score cannot be blank ')]
    #[Assert\NotNull(message: 'The score cannot be null')]
    private ?float $score = null;

    #[ORM\Column]
    private ?bool $etat = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'The nbrQuestion cannot be null')]
    #[Assert\NotBlank(message: 'The nbrQuestion cannot be blank ')]
    #[Assert\Type("integer")]
    #[Assert\GreaterThanOrEqual(0)]
    private ?int $nbrQuestion = null;

    #[ORM\ManyToOne(inversedBy: 'devoirs')]
    private ?Formation $id_formation = null;

    #[ORM\OneToMany(mappedBy: 'devoir', targetEntity: Question::class, cascade: ['persist'])]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(?\DateTimeInterface $heureFin): static
    {
        if ($heureFin) {
            $today = new \DateTime();
            $heureFin->setDate($today->format('Y'), $today->format('m'), $today->format('d'));
        }
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getNbrQuestion(): ?int
    {
        return $this->nbrQuestion;
    }

    public function setNbrQuestion(int $nbrQuestion): static
    {
        $this->nbrQuestion = $nbrQuestion;

        return $this;
    }

    public function getIdFormation(): ?Formation
    {
        return $this->id_formation;
    }

    public function setIdFormation(?Formation $id_formation): static
    {
        $this->id_formation = $id_formation;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setDevoir($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getDevoir() === $this) {
                $question->setDevoir(null);
            }
        }

        return $this;
    }
}
