<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Domain\Dto;

use SocialApp\Security\UserStore\Domain\Model\User;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    public function __construct(
        #[Assert\Uuid]
        public ?AbstractUid $id = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 50, groups: ['create', 'Default'])]
        public ?string $name = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 100, groups: ['create', 'Default'])]
        public ?string $password = null,

        #[Assert\Length(min: 1, max: 100, groups: ['create', 'Default'])]
        public ?string $fullName = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?bool $isActive = null,
    ) {
    }

    public static function fromModel(User $user): static
    {
        return new self(
            id: $user->id()->value,
            name: $user->name()->value,
            fullName: $user->fullName()->value,
            isActive: $user->isActive()->value,
        );
    }
}
