<?php

declare(strict_types=1);

namespace SocialApp\Apps\Demo\Webapp\BookCategory\Controller;

use SocialApp\Demo\BookCategory\Application\Query\FindBookCategoriesQuery;
use SocialApp\Demo\BookCategory\Domain\Dto\BookCategoryDto;
use SocialApp\Demo\BookCategory\Domain\Repository\BookCategoryRepositoryInterface;
use SocialApp\Shared\Application\Query\QueryBusInterface;
use SocialApp\Shared\Infrastructure\Api\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetBookCategoriesController extends AbstractController
{
    #[Route('/', name: 'book_category_index')]
    public function __invoke(QueryBusInterface $queryBus): Response
    {
        /** @var BookCategoryRepositoryInterface $models */
        $models = $queryBus->ask(new FindBookCategoriesQuery(null, 1, 10));

        $resources = [];
        foreach ($models as $model) {
            $resources[] = BookCategoryDto::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = new Paginator(
                new \ArrayIterator($resources),
                $paginator->getCurrentPage(),
                $paginator->getItemsPerPage(),
                $paginator->getLastPage(),
                $paginator->getTotalItems(),
            );
        }

        return $this->render('book_category/index.html.twig', [
            'book_categories' => $resources,
        ]);
    }
}
