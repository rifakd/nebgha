<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant extends User // Hérite de User
{
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $niveauEtude = null;

    #[ORM\Column(length: 255)]
    private ?string $parcourSuivi = null;

    /**
     * @var Collection<int, Formation>
     */
    #[ORM\ManyToMany(targetEntity: Formation::class, mappedBy: 'etudiants')]
    private Collection $formations;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'etudiant')]
    private Collection $commentaires;

    /**
     * @var Collection<int, ReponseEtudiant>
     */
    #[ORM\OneToMany(targetEntity: ReponseEtudiant::class, mappedBy: 'etudiant')]
    private Collection $reponseEtudiants;

        public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->reponseEtudiants = new ArrayCollection();
    }

    // Getters et setters spécifiques à l'étudiant

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(string $niveauEtude): static
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    public function getParcourSuivi(): ?string
    {
        return $this->parcourSuivi;
    }

    public function setParcourSuivi(string $parcourSuivi): static
    {
        $this->parcourSuivi = $parcourSuivi;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->addEtudiant($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): static
    {
        if ($this->formations->removeElement($formation)) {
            $formation->removeEtudiant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setEtudiant($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEtudiant() === $this) {
                $commentaire->setEtudiant(null);
            }
        }

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
            $reponseEtudiant->setEtudiant($this);
        }

        return $this;
    }

    public function removeReponseEtudiant(ReponseEtudiant $reponseEtudiant): static
    {
        if ($this->reponseEtudiants->removeElement($reponseEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($reponseEtudiant->getEtudiant() === $this) {
                $reponseEtudiant->setEtudiant(null);
            }
        }

        return $this;
    }
}

