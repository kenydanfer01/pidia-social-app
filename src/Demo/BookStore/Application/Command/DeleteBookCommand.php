<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Shared\Application\Command\CommandInterface;

final class DeleteBookCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $id,
    ) {
    }
}
