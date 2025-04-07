<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $bookTitle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $bookSummary = null;

    #[ORM\Column]
    private ?int $bookISBN = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editor $bookEditor = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $book_author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookTitle(): ?string
    {
        return $this->bookTitle;
    }

    public function setBookTitle(string $bookTitle): static
    {
        $this->bookTitle = $bookTitle;

        return $this;
    }

    public function getBookSummary(): ?string
    {
        return $this->bookSummary;
    }

    public function setBookSummary(string $bookSummary): static
    {
        $this->bookSummary = $bookSummary;

        return $this;
    }

    public function getBookISBN(): ?int
    {
        return $this->bookISBN;
    }

    public function setBookISBN(int $bookISBN): static
    {
        $this->bookISBN = $bookISBN;

        return $this;
    }

    public function getBookEditor(): ?Editor
    {
        return $this->bookEditor;
    }

    public function setBookEditor(?Editor $bookEditor): static
    {
        $this->bookEditor = $bookEditor;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
