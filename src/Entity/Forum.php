<?php

namespace App\Entity;

use App\Repository\ForumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ForumRepository::class)]
class Forum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'The sujet cannot be blank')]
    #[Assert\NotNull(message: 'The sujet cannot be null')]
    #[Assert\Length(
        min: 5,
        max: 100,
        minMessage: 'The cours name must be at least {{ limit }} characters long.',
        maxMessage: 'The cours name cannot exceed {{ limit }} characters.'
    )]  
        private ?string $sujet = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'The description cannot be blank')]
    #[Assert\NotNull(message: 'The description cannot be null')]
    #[Assert\Length(
        min: 5,
        max: 100,
        minMessage: 'The cours name must be at least {{ limit }} characters long.',
        maxMessage: 'The cours name cannot exceed {{ limit }} characters.'
    )] 
        private ?string $description = null;

    #[ORM\OneToOne(inversedBy: 'forum', cascade: ['persist', 'remove'])]
    private ?Cours $id_Cours = null;

    /**
     * @var Collection<int, Chat>
     */
    #[ORM\OneToMany(targetEntity: Chat::class, mappedBy: 'forum')]
    private Collection $chats;

    public function __construct()
    {
        $this->chats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): static
    {
        $this->sujet = $sujet;

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

    public function getIdCours(): ?Cours
    {
        return $this->id_Cours;
    }

    public function setIdCours(?Cours $id_Cours): static
    {
        $this->id_Cours = $id_Cours;

        return $this;
    }

    /**
     * @return Collection<int, Chat>
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): static
    {
        if (!$this->chats->contains($chat)) {
            $this->chats->add($chat);
            $chat->setForum($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): static
    {
        if ($this->chats->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getForum() === $this) {
                $chat->setForum(null);
            }
        }

        return $this;
    }
}
