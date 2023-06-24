<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Domain\ValueObject;

use SocialApp\Shared\Domain\ValueObject\AggregateRootId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class BookCategoryId implements \Stringable
{
    use AggregateRootId;
}
