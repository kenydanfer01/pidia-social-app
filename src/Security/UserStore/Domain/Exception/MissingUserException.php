<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Domain\Exception;

use SocialApp\Security\UserStore\Domain\ValueObject\UserId;

final class MissingUserException extends \RuntimeException
{
    public function __construct(UserId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find user with id %s', (string) $id), $code, $previous);
    }
}
