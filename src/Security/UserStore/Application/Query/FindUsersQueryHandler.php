<?php

declare(strict_types=1);

namespace SocialApp\Security\UserStore\Application\Query;

use SocialApp\Security\UserStore\Domain\Repository\UserRepositoryInterface;
use SocialApp\Shared\Application\Query\QueryHandlerInterface;

final class FindUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(FindUsersQuery $query): UserRepositoryInterface
    {
        $userRepository = $this->userRepository;

        if (null !== $query->searchText) {
            $userRepository = $userRepository->withSearchText($query->searchText);
        }

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $userRepository = $userRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $userRepository;
    }
}
