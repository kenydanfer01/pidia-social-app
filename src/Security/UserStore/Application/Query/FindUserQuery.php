<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Application\Query;

use SocialApp\Security\UserStore\Domain\ValueObject\UserId;
use SocialApp\Shared\Application\Query\QueryInterface;

final class FindUserQuery implements QueryInterface
{
    public function __construct(
        public readonly UserId $id,
    ) {
    }
}
