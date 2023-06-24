<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Demo\BookStore\Domain\ValueObject\Author;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookContent;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookDescription;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookName;
use SocialApp\Demo\BookStore\Domain\ValueObject\Price;
use SocialApp\Shared\Application\Command\CommandInterface;

final class CreateBookCommand implements CommandInterface
{
    public function __construct(
        public readonly BookName $name,
        public readonly BookDescription $description,
        public readonly Author $author,
        public readonly BookContent $content,
        public readonly Price $price,
        public readonly BookCategoryId $categoryId,

        /** @var BookCategoryId[] */
        public readonly array $categoryIds = [],
    ) {
    }
}
