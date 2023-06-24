<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Application\Query;

use SocialApp\Shared\Application\Query\QueryInterface;
use SocialApp\Shared\Domain\ValueObject\SearchText;

final class FindUsersQuery implements QueryInterface
{
    public function __construct(
        public readonly ?SearchText $searchText = null,
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }
}
