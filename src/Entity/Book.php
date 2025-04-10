<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?Author $bookAuthor = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $book_cover = null;

    /**
     * @var Collection<int, MarkedByUser>
     */
    #[ORM\OneToMany(targetEntity: MarkedByUser::class, mappedBy: 'book')]
    private Collection $markedByUsers;

    public function __construct()
    {
        $this->markedByUsers = new ArrayCollection();
    }

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

    public function getBookAuthor(): ?Author
    {
        return $this->bookAuthor;
    }

    public function setBookAuthor(?Author $bookAuthor): static
    {
        $this->bookAuthor = $bookAuthor;

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

    public function getBookCover(): ?string
    {
        return $this->book_cover;
    }

    public function setBookCover(?string $book_cover): static
    {
        $this->book_cover = $book_cover;

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
            $markedByUser->setBook($this);
        }

        return $this;
    }

    public function removeMarkedByUser(MarkedByUser $markedByUser): static
    {
        if ($this->markedByUsers->removeElement($markedByUser)) {
            // set the owning side to null (unless already changed)
            if ($markedByUser->getBook() === $this) {
                $markedByUser->setBook(null);
            }
        }

        return $this;
    }
}
