<?php

declare(strict_types=1);

namespace SocialApp\Apps\Demo\Webapp\BookStore\Controller;

use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Demo\BookStore\Application\Query\FindBooksQuery;
use SocialApp\Demo\BookStore\Domain\Dto\BookDto;
use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Shared\Application\Query\QueryBusInterface;
use SocialApp\Shared\Infrastructure\Api\Paginator;
use SocialApp\Shared\Infrastructure\Pagination\PaginationParams;
use SocialApp\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetBooksController extends WebController
{
    #[Route('/', name: 'book_index')]
    public function __invoke(Request $request, QueryBusInterface $queryBus): Response
    {
        $params = PaginationParams::ofRequest(ParamFetcher::fromRequestQuery($request));

        /** @var BookRepositoryInterface $models */
        $models = $queryBus->ask(new FindBooksQuery($params->searchText, $params->page, $params->itemsPerPage));

        $resources = [];
        foreach ($models as $model) {
            $resources[] = BookDto::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = Paginator::ofModel($resources, $paginator);
        }

        return $this->render('book_store/index.html.twig', [
            'books' => $resources,
        ]);
    }
}
