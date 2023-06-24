<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Domain\ValueObject;

use SocialApp\Shared\Domain\ValueObject\IsActive;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class UserIsActive
{
    use IsActive;
}
