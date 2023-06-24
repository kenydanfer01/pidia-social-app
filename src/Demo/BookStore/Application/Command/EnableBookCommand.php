<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Shared\Application\Command\CommandInterface;

final class EnableBookCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $id,
    ) {
    }
}
