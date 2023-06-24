<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Shared\Application\Command\CommandInterface;

final class AnonymizeBooksCommand implements CommandInterface
{
    public function __construct(
        public readonly string $anonymizedName,
    ) {
    }
}
