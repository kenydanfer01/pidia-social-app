<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Query;

use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Shared\Application\Query\QueryInterface;

final class FindBookQuery implements QueryInterface
{
    public function __construct(
        public readonly BookId $id,
    ) {
    }
}
