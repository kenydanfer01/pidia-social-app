<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Application\Command;

use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryDescription;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryName;
use SocialApp\Shared\Application\Command\CommandInterface;

final class UpdateBookCategoryCommand implements CommandInterface
{
    public function __construct(
        public readonly BookCategoryId $id,
        public readonly ?BookCategoryName $name = null,
        public readonly ?BookCategoryDescription $description = null,
    ) {
    }
}
