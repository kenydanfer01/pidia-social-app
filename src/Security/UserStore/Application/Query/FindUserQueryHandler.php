<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Application\Query;

use SocialApp\Security\UserStore\Domain\Model\User;
use SocialApp\Security\UserStore\Domain\Repository\UserRepositoryInterface;
use SocialApp\Shared\Application\Query\QueryHandlerInterface;

final class FindUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    public function __invoke(FindUserQuery $query): ?User
    {
        return $this->repository->ofId($query->id);
    }
}
