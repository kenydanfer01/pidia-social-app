<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Query;

use SocialApp\Demo\BookStore\Domain\ValueObject\Author;
use SocialApp\Shared\Application\Query\QueryInterface;
use SocialApp\Shared\Domain\ValueObject\SearchText;

final class FindBooksQuery implements QueryInterface
{
    public function __construct(
        public readonly ?SearchText $searchText = null,
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }
}
