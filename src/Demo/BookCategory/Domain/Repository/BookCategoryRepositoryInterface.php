<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Domain\Repository;

use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryName;
use SocialApp\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<BookCategory>
 */
interface BookCategoryRepositoryInterface extends RepositoryInterface
{
    public function save(BookCategory $book): void;

    public function remove(BookCategory $book): void;

    public function ofId(BookCategoryId $id): ?BookCategory;

    public function withName(BookCategoryName $name): static;
}
