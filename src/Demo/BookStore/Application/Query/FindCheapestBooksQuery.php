<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Query;

use SocialApp\Shared\Application\Query\QueryInterface;

final class FindCheapestBooksQuery implements QueryInterface
{
    public function __construct(public readonly int $size = 10)
    {
    }
}
