<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $intitule = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reponseCorrecte = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    private ?Devoir $devoir = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $choices = null;

    /**
     * @var Collection<int, ReponseEtudiant>
     */
    #[ORM\OneToMany(targetEntity: ReponseEtudiant::class, mappedBy: 'question')]
    private Collection $reponseEtudiants;

    public function __construct()
    {
        $this->reponseEtudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(?string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getReponseCorrecte(): ?string
    {
        return $this->reponseCorrecte;
    }

    public function setReponseCorrecte(?string $reponseCorrecte): static
    {
        $this->reponseCorrecte = $reponseCorrecte;

        return $this;
    }

    public function getDevoir(): ?Devoir
    {
        return $this->devoir;
    }

    public function setDevoir(?Devoir $devoir): static
    {
        $this->devoir = $devoir;

        return $this;
    }

    /**
     * @return Collection<int, ReponseEtudiant>
     */
    public function getReponseEtudiants(): Collection
    {
        return $this->reponseEtudiants;
    }

    public function addReponseEtudiant(ReponseEtudiant $reponseEtudiant): static
    {
        if (!$this->reponseEtudiants->contains($reponseEtudiant)) {
            $this->reponseEtudiants->add($reponseEtudiant);
            $reponseEtudiant->setQuestion($this);
        }

        return $this;
    }

    public function removeReponseEtudiant(ReponseEtudiant $reponseEtudiant): static
    {
        if ($this->reponseEtudiants->removeElement($reponseEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($reponseEtudiant->getQuestion() === $this) {
                $reponseEtudiant->setQuestion(null);
            }
        }

        return $this;
    }

    public function getChoices(): ?array
    {
        return $this->choices;
    }

    public function setChoices(?array $choices): static
    {
        $this->choices = $choices;

        return $this;
    }

    public function __toString(): string
    {
        return $this->intitule ?? '';
    }
}
