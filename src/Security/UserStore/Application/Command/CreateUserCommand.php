<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Security\UserStore\Application\Command;

use SocialApp\Security\UserStore\Domain\ValueObject\UserFullName;
use SocialApp\Security\UserStore\Domain\ValueObject\UserName;
use SocialApp\Security\UserStore\Domain\ValueObject\UserPassword;
use SocialApp\Shared\Application\Command\CommandInterface;

final class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly UserName $name,
        public readonly UserPassword $password,
        public readonly UserFullName $fullName,
    ) {
    }
}
