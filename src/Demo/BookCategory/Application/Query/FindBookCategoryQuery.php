<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Application\Query;

use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Shared\Application\Query\QueryInterface;

final class FindBookCategoryQuery implements QueryInterface
{
    public function __construct(
        public readonly BookCategoryId $id,
    ) {
    }
}
