<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Demo\BookStore\Domain\Model;

use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookStore\Domain\ValueObject\Author;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookContent;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookDescription;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookIsActive;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookName;
use SocialApp\Demo\BookStore\Domain\ValueObject\Discount;
use SocialApp\Demo\BookStore\Domain\ValueObject\Price;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Book
{
    #[ORM\Embedded(columnPrefix: false)]
    private readonly BookId $id;

    #[ORM\Embedded(columnPrefix: false)]
    private BookIsActive $isActive;

    #[ORM\ManyToMany(targetEntity: BookCategory::class)]
    #[ORM\JoinTable(name: 'book_book_category_categories')]
    private Collection $categories;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private BookName $name,

        #[ORM\Embedded(columnPrefix: false)]
        private BookDescription $description,

        #[ORM\Embedded(columnPrefix: false)]
        private Author $author,

        #[ORM\Embedded(columnPrefix: false)]
        private BookContent $content,

        #[ORM\Embedded(columnPrefix: false)]
        private Price $price,

        #[ORM\ManyToOne(targetEntity: BookCategory::class)]
        #[ORM\JoinColumn(nullable: true)]
        private ?BookCategory $category = null,
    ) {
        $this->id = new BookId();
        $this->isActive = new BookIsActive();
        $this->categories = new ArrayCollection();
    }

    public function update(
        ?BookName $name = null,
        ?BookDescription $description = null,
        ?Author $author = null,
        ?BookContent $content = null,
        ?Price $price = null,
        ?BookCategory $category = null,
    ): void {
        $this->name = $name ?? $this->name;
        $this->description = $description ?? $this->description;
        $this->author = $author ?? $this->author;
        $this->content = $content ?? $this->content;
        $this->price = $price ?? $this->price;
        $this->category = $category ?? $this->category;
    }

    public function applyDiscount(Discount $discount): static
    {
        $this->price = $this->price->applyDiscount($discount);

        return $this;
    }

    public function addCategory(BookCategory $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(BookCategory $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function removeCategoriesNotSelected(array $categoryIds): void
    {
        foreach ($this->categories() as $category) {
            $existCategory = false;
            foreach ($categoryIds as $categoryId) {
                if ($categoryId->value === $category->id()->value) {
                    $existCategory = true;
                    break;
                }
            }
            if (!$existCategory) {
                $this->removeCategory($category);
            }
        }
    }

    public function id(): BookId
    {
        return $this->id;
    }

    public function name(): BookName
    {
        return $this->name;
    }

    public function description(): BookDescription
    {
        return $this->description;
    }

    public function author(): Author
    {
        return $this->author;
    }

    public function content(): BookContent
    {
        return $this->content;
    }

    public function price(): Price
    {
        return $this->price;
    }

    public function isActive(): BookIsActive
    {
        return $this->isActive;
    }

    public function category(): ?BookCategory
    {
        return $this->category;
    }

    /** @return BookCategory[]|Collection */
    public function categories(): array|Collection
    {
        return $this->categories;
    }

    public function disable(): static
    {
        $this->isActive = new BookIsActive(false);

        return $this;
    }

    public function enable(): static
    {
        $this->isActive = new BookIsActive(true);

        return $this;
    }
}
