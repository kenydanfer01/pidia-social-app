<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Query;

use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Shared\Application\Query\QueryHandlerInterface;

final class FindCheapestBooksQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly BookRepositoryInterface $bookRepository)
    {
    }

    public function __invoke(FindCheapestBooksQuery $query): BookRepositoryInterface
    {
        return $this->bookRepository
            ->withCheapestsFirst()
            ->withPagination(1, $query->size);
    }
}
