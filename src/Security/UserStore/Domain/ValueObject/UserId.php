<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Domain\ValueObject;

use SocialApp\Shared\Domain\ValueObject\AggregateRootId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class UserId implements \Stringable
{
    use AggregateRootId;
}
