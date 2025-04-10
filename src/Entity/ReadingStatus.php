<?php

namespace App\Entity;

use App\Repository\ReadingStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReadingStatusRepository::class)]
class ReadingStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, MarkedByUser>
     */
    #[ORM\OneToMany(targetEntity: MarkedByUser::class, mappedBy: 'readingStatus')]
    private Collection $markedByUsers;

    public function __construct()
    {
        $this->markedByUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, MarkedByUser>
     */
    public function getMarkedByUsers(): Collection
    {
        return $this->markedByUsers;
    }

    public function addMarkedByUser(MarkedByUser $markedByUser): static
    {
        if (!$this->markedByUsers->contains($markedByUser)) {
            $this->markedByUsers->add($markedByUser);
            $markedByUser->setReadingStatus($this);
        }

        return $this;
    }

    public function removeMarkedByUser(MarkedByUser $markedByUser): static
    {
        if ($this->markedByUsers->removeElement($markedByUser)) {
            // set the owning side to null (unless already changed)
            if ($markedByUser->getReadingStatus() === $this) {
                $markedByUser->setReadingStatus(null);
            }
        }

        return $this;
    }
}
