<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Demo\BookStore\Domain\Dto;

use SocialApp\Demo\BookCategory\Domain\Dto\BookCategoryDto;
use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookStore\Domain\Model\Book;
use SocialApp\Shared\Domain\Dto\AbstractDto;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Validator\Constraints as Assert;

class BookDto extends AbstractDto
{
    public function __construct(
        #[Assert\Uuid]
        public ?AbstractUid $id = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'Default'])]
        public ?string $name = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 1023, groups: ['create', 'Default'])]
        public ?string $description = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'Default'])]
        public ?string $author = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 65535, groups: ['create', 'Default'])]
        public ?string $content = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\PositiveOrZero(groups: ['create', 'Default'])]
        public ?int $price = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?bool $isActive = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?BookCategoryDto $category = null,

        /** @var BookCategoryDto[] */
        public array $categories = [],
    ) {
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }

    public static function fromModel(Book $book): static
    {
        return new self(
            $book->id()->value,
            $book->name()->value,
            $book->description()->value,
            $book->author()->value,
            $book->content()->value,
            $book->price()->amount,
            $book->isActive()->value,
            BookCategoryDto::fromModel($book->category()),
            array_map(fn (BookCategory $category) => BookCategoryDto::fromModel($category), $book->categories()->toArray()),
        );
    }
}
