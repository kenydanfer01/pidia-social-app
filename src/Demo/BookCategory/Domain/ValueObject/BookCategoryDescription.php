<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class BookCategoryDescription
{
    #[ORM\Column(name: 'description', length: 255)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::lengthBetween($value, 1, 255);

        $this->value = $value;
    }
}
