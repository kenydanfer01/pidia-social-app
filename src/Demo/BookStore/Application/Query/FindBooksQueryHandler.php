<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Demo\BookStore\Application\Query;

use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Shared\Application\Query\QueryHandlerInterface;

final class FindBooksQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository
    ) {
    }

    public function __invoke(FindBooksQuery $query): BookRepositoryInterface
    {
        $bookRepository = $this->bookRepository;

        if (null !== $query->searchText) {
            $bookRepository = $bookRepository->withSearchText($query->searchText);
        }

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $bookRepository = $bookRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $bookRepository;
    }
}
