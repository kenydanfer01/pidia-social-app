<?php

declare(strict_types=1);

namespace SocialApp\Apps\Security\Webapp\UserStore\Controller;

use SocialApp\Security\UserStore\Application\Command\DeleteUserCommand;
use SocialApp\Security\UserStore\Domain\ValueObject\UserId;
use SocialApp\Shared\Application\Command\CommandBusInterface;
use SocialApp\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class DeleteUserController extends WebController
{
    #[Route('/{id}/delete', name: 'user_delete', methods: ['POST'])]
    public function __invoke(Request $request, Uuid $id, CommandBusInterface $commandBus): Response
    {
        $commandBus->dispatch(new DeleteUserCommand(new UserId($id)));

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
