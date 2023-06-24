<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Application\Command;

use SocialApp\Security\UserStore\Domain\ValueObject\UserId;
use SocialApp\Shared\Application\Command\CommandInterface;

final class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public readonly UserId $id,
    ) {
    }
}
