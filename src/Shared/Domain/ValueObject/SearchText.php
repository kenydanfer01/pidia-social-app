<?php

declare(strict_types=1);

namespace SocialApp\Shared\Domain\ValueObject;

final class SearchText
{
    public string $value;

    public function __construct(
        string $value,
    ) {
        $this->value = trim($value);
    }
}
