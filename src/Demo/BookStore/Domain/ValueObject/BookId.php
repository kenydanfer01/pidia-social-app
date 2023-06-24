<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Domain\ValueObject;

use SocialApp\Shared\Domain\ValueObject\AggregateRootId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class BookId implements \Stringable
{
    use AggregateRootId;
}
