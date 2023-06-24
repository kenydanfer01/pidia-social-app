<?php

declare(strict_types=1);

namespace SocialApp\Apps\Security\Webapp\UserStore\Controller;

use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Security\UserStore\Application\Query\FindUsersQuery;
use SocialApp\Security\UserStore\Domain\Dto\UserDto;
use SocialApp\Security\UserStore\Domain\Repository\UserRepositoryInterface;
use SocialApp\Shared\Application\Query\QueryBusInterface;
use SocialApp\Shared\Infrastructure\Api\Paginator;
use SocialApp\Shared\Infrastructure\Pagination\PaginationParams;
use SocialApp\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetUsersController extends WebController
{
    #[Route('/', name: 'user_index')]
    public function __invoke(Request $request, QueryBusInterface $queryBus): Response
    {
        $params = PaginationParams::ofRequest(ParamFetcher::fromRequestQuery($request));

        /** @var UserRepositoryInterface $models */
        $models = $queryBus->ask(new FindUsersQuery($params->searchText, $params->page, $params->itemsPerPage));

        $resources = [];
        foreach ($models as $model) {
            $resources[] = UserDto::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = Paginator::ofModel($resources, $paginator);
        }

        return $this->render('user_store/index.html.twig', [
            'users' => $resources,
        ]);
    }
}
