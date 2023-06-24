<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Infrastructure\InMemory;

use SocialApp\Demo\BookStore\Domain\Model\Book;
use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Demo\BookStore\Domain\ValueObject\Author;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Shared\Domain\ValueObject\SearchText;
use SocialApp\Shared\Infrastructure\InMemory\InMemoryRepository;

/**
 * @extends InMemoryRepository<Book>
 */
final class InMemoryBookRepository extends InMemoryRepository implements BookRepositoryInterface
{
    public function save(Book $book): void
    {
        $this->entities[(string) $book->id()] = $book;
    }

    public function remove(Book $book): void
    {
        unset($this->entities[(string) $book->id()]);
    }

    public function ofId(BookId $id): ?Book
    {
        return $this->entities[(string) $id] ?? null;
    }

    public function withSearchText(SearchText $searchText): static
    {
        return $this->filter(fn (Book $book) => $book->name()->value === $searchText->value);
    }

    public function withCheapestsFirst(): static
    {
        $cloned = clone $this;
        uasort($cloned->entities, fn (Book $a, Book $b) => $a->price() <=> $b->price());

        return $cloned;
    }
}
