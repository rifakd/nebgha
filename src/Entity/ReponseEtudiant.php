<?php

namespace App\Entity;

use App\Repository\ReponseEtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseEtudiantRepository::class)]
class ReponseEtudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reponseEtudiants')]
    private ?Question $question = null;

    #[ORM\ManyToOne(inversedBy: 'reponseEtudiants')]
    private ?Etudiant $etudiant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reponseDonnee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getReponseDonnee(): ?string
    {
        return $this->reponseDonnee;
    }

    public function setReponseDonnee(?string $reponseDonnee): static
    {
        $this->reponseDonnee = $reponseDonnee;

        return $this;
    }
}
