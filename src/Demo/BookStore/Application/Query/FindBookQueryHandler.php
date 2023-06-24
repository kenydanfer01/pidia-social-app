<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Query;

use SocialApp\Demo\BookStore\Domain\Model\Book;
use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Shared\Application\Query\QueryHandlerInterface;

final class FindBookQueryHandler implements QueryHandlerInterface
{
    public function __construct(private BookRepositoryInterface $repository)
    {
    }

    public function __invoke(FindBookQuery $query): ?Book
    {
        return $this->repository->ofId($query->id);
    }
}
