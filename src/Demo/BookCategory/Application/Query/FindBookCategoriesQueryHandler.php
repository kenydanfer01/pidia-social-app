<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Application\Query;

use SocialApp\Demo\BookCategory\Domain\Repository\BookCategoryRepositoryInterface;
use SocialApp\Shared\Application\Query\QueryHandlerInterface;

final class FindBookCategoriesQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly BookCategoryRepositoryInterface $bookCategoryRepository)
    {
    }

    public function __invoke(FindBookCategoriesQuery $query): BookCategoryRepositoryInterface
    {
        $bookCategoryRepository = $this->bookCategoryRepository;

        if (null !== $query->name) {
            $bookCategoryRepository = $bookCategoryRepository->withName($query->name);
        }

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $bookCategoryRepository = $bookCategoryRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $bookCategoryRepository;
    }
}
