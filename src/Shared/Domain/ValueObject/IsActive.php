<?php

declare(strict_types=1);

namespace SocialApp\Shared\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

trait IsActive
{
    #[ORM\Column(name: 'is_active', type: 'boolean')]
    public readonly bool $value;

    public function __construct(bool $value = true)
    {
        $this->value = $value;
    }

    public function change(): self
    {
        return new static(!$this->value);
    }
}
