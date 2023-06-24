<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class UserFullName
{
    #[ORM\Column(name: 'fullName', length: 100)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::lengthBetween($value, 1, 100);

        $this->value = $value;
    }
}
