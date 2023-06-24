<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Application\Query;

use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryName;
use SocialApp\Shared\Application\Query\QueryInterface;

final class FindBookCategoriesQuery implements QueryInterface
{
    public function __construct(
        public readonly ?BookCategoryName $name = null,
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }
}
