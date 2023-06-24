<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Application\Command;

use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Shared\Application\Command\CommandInterface;

final class DeleteBookCategoryCommand implements CommandInterface
{
    public function __construct(
        public readonly BookCategoryId $id,
    ) {
    }
}
