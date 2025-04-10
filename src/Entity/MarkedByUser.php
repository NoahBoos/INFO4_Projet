<?php

namespace App\Entity;

use App\Repository\MarkedByUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarkedByUserRepository::class)]
class MarkedByUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'markedByUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'markedByUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'markedByUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ReadingStatus $readingStatus = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getReadingStatus(): ?ReadingStatus
    {
        return $this->readingStatus;
    }

    public function setReadingStatus(?ReadingStatus $readingStatus): static
    {
        $this->readingStatus = $readingStatus;

        return $this;
    }
}
