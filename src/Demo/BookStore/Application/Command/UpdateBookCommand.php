<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Demo\BookStore\Domain\ValueObject\Author;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookContent;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookDescription;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookName;
use SocialApp\Demo\BookStore\Domain\ValueObject\Price;
use SocialApp\Shared\Application\Command\CommandInterface;

final class UpdateBookCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $id,
        public readonly ?BookName $name = null,
        public readonly ?BookDescription $description = null,
        public readonly ?Author $author = null,
        public readonly ?BookContent $content = null,
        public readonly ?Price $price = null,
        public readonly ?BookCategoryId $categoryId = null,

        /** @var BookCategoryId[] */
        public readonly array $categoryIds = [],
    ) {
    }
}
