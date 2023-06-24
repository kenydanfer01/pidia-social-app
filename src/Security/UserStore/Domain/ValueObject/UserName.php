<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class UserName
{
    #[ORM\Column(name: 'name', length: 50)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::lengthBetween($value, 1, 50);

        $this->value = $value;
    }

    public function isEqualTo(self $name): bool
    {
        return $name->value === $this->value;
    }
}
