<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Domain\Repository;

use SocialApp\Security\UserStore\Domain\Model\User;
use SocialApp\Security\UserStore\Domain\ValueObject\UserId;
use SocialApp\Security\UserStore\Domain\ValueObject\UserName;
use SocialApp\Shared\Domain\Repository\RepositoryInterface;
use SocialApp\Shared\Domain\ValueObject\SearchText;

/**
 * @extends RepositoryInterface<User>
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function save(User $user): void;

    public function remove(User $user): void;

    public function ofId(UserId $id): ?User;

    public function withSearchText(SearchText $searchText): static;
}
