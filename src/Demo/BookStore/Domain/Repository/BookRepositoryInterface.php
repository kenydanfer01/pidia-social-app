<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Domain\Repository;

use SocialApp\Demo\BookStore\Domain\Model\Book;
use SocialApp\Demo\BookStore\Domain\ValueObject\Author;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Shared\Domain\Repository\RepositoryInterface;
use SocialApp\Shared\Domain\ValueObject\SearchText;

/**
 * @extends RepositoryInterface<Book>
 */
interface BookRepositoryInterface extends RepositoryInterface
{
    public function save(Book $book): void;

    public function remove(Book $book): void;

    public function ofId(BookId $id): ?Book;

    public function withSearchText(SearchText $searchText): static;

    public function withCheapestsFirst(): static;
}
