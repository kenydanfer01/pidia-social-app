<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Infrastructure\InMemory;

use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookCategory\Domain\Repository\BookCategoryRepositoryInterface;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryName;
use SocialApp\Shared\Infrastructure\InMemory\InMemoryRepository;

/**
 * @extends InMemoryRepository<BookCategory>
 */
class InMemoryBookCategoryRepository extends InMemoryRepository implements BookCategoryRepositoryInterface
{
    public function save(BookCategory $book): void
    {
        $this->entities[(string) $book->id()] = $book;
    }

    public function remove(BookCategory $book): void
    {
        unset($this->entities[(string) $book->id()]);
    }

    public function ofId(BookCategoryId $id): ?BookCategory
    {
        return $this->entities[(string) $id] ?? null;
    }

    public function withName(BookCategoryName $name): static
    {
        return $this->filter(fn (BookCategory $book) => $book->name()->isEqualTo($name));
    }
}
