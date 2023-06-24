<?php

declare(strict_types=1);

namespace SocialApp\Apps\Security\Webapp\UserStore\Controller;

use SocialApp\Apps\Security\Webapp\UserStore\Form\UserType;
use SocialApp\Security\UserStore\Application\Command\UpdateUserCommand;
use SocialApp\Security\UserStore\Application\Query\FindUserQuery;
use SocialApp\Security\UserStore\Domain\Dto\UserDto;
use SocialApp\Security\UserStore\Domain\Model\User;
use SocialApp\Security\UserStore\Domain\ValueObject\UserFullName;
use SocialApp\Security\UserStore\Domain\ValueObject\UserId;
use SocialApp\Security\UserStore\Domain\ValueObject\UserName;
use SocialApp\Security\UserStore\Domain\ValueObject\UserPassword;
use SocialApp\Shared\Application\Command\CommandBusInterface;
use SocialApp\Shared\Application\Query\QueryBusInterface;
use SocialApp\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class UpdateUserController extends WebController
{
    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function __invoke(
        Request $request,
        Uuid $id,
        QueryBusInterface $queryBus,
        CommandBusInterface $commandBus,
    ): Response {

        /** @var User|null $model */
        $model = $queryBus->ask(new FindUserQuery(new UserId($id)));
        if (null === $model) {
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        $user = UserDto::fromModel($model);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new UpdateUserCommand(
                new UserId($user->id),
                null !== $user->name ? new UserName($user->name) : null,
                null !== $user->password ? new UserPassword($user->password) : null,
                null !== $user->fullName ? new UserFullName($user->fullName) : null,
            );

            $commandBus->dispatch($command);

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_store/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
