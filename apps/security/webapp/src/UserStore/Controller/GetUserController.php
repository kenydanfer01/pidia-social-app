<?php

declare(strict_types=1);

namespace SocialApp\Apps\Security\Webapp\UserStore\Controller;

use SocialApp\Security\UserStore\Application\Query\FindUserQuery;
use SocialApp\Security\UserStore\Domain\Dto\UserDto;
use SocialApp\Security\UserStore\Domain\Model\User;
use SocialApp\Security\UserStore\Domain\ValueObject\UserId;
use SocialApp\Shared\Application\Query\QueryBusInterface;
use SocialApp\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class GetUserController extends WebController
{
    #[Route('/{id}/show', name: 'user_show', methods: ['GET'])]
    public function __invoke(Uuid $id, QueryBusInterface $queryBus): Response
    {
        /** @var User|null $model */
        $model = $queryBus->ask(new FindUserQuery(new UserId($id)));

        if (null === $model) {
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        $user = UserDto::fromModel($model);

        return $this->render('user_store/show.html.twig', [
            'user' => $user,
        ]);
    }
}
