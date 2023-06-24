<?php

declare(strict_types=1);

namespace SocialApp\Apps\Security\Webapp\UserStore\Controller;

use SocialApp\Apps\Security\Webapp\UserStore\Form\UserType;
use SocialApp\Security\UserStore\Application\Command\CreateUserCommand;
use SocialApp\Security\UserStore\Domain\Dto\UserDto;
use SocialApp\Security\UserStore\Domain\ValueObject\UserFullName;
use SocialApp\Security\UserStore\Domain\ValueObject\UserName;
use SocialApp\Security\UserStore\Domain\ValueObject\UserPassword;
use SocialApp\Shared\Application\Command\CommandBusInterface;
use SocialApp\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateUserController extends WebController
{
    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, CommandBusInterface $commandBus): Response
    {
        $user = new UserDto();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new CreateUserCommand(
                new UserName($user->name),
                new UserPassword($user->password),
                new UserFullName($user->fullName),
            );

            $commandBus->dispatch($command);

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_store/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
