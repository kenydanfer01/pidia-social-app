<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Security\UserStore\Infrastructure\InMemory;

use SocialApp\Security\UserStore\Domain\Model\User;
use SocialApp\Security\UserStore\Domain\Repository\UserRepositoryInterface;
use SocialApp\Security\UserStore\Domain\ValueObject\UserId;
use SocialApp\Security\UserStore\Domain\ValueObject\UserName;
use SocialApp\Shared\Domain\ValueObject\SearchText;
use SocialApp\Shared\Infrastructure\InMemory\InMemoryRepository;

/**
 * @extends InMemoryRepository<User>
 */
class InMemoryUserRepository extends InMemoryRepository implements UserRepositoryInterface
{
    public function save(User $user): void
    {
        $this->entities[(string) $user->id()] = $user;
    }

    public function remove(User $user): void
    {
        unset($this->entities[(string) $user->id()]);
    }

    public function ofId(UserId $id): ?User
    {
        return $this->entities[(string) $id] ?? null;
    }

    public function withSearchText(SearchText $searchText): static
    {
        return $this->filter(fn (User $user) => $user->name()->value === $searchText->value);
    }
}
