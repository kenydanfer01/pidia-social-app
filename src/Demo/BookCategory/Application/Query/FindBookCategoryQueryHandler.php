<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Application\Query;

use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookCategory\Domain\Repository\BookCategoryRepositoryInterface;
use SocialApp\Shared\Application\Query\QueryHandlerInterface;

final class FindBookCategoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly BookCategoryRepositoryInterface $categoryRepository)
    {
    }

    public function __invoke(FindBookCategoryQuery $query): ?BookCategory
    {
        return $this->categoryRepository->ofId($query->id);
    }
}
