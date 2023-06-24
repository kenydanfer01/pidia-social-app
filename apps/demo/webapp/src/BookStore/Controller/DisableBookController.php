<?php

declare(strict_types=1);

namespace SocialApp\Apps\Demo\Webapp\BookStore\Controller;

use SocialApp\Demo\BookStore\Application\Command\DisableBookCommand;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Shared\Application\Command\CommandBusInterface;
use SocialApp\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class DisableBookController extends WebController
{
    #[Route('/{id}/disable', name: 'book_disable', methods: ['POST'])]
    public function __invoke(Request $request, Uuid $id, CommandBusInterface $commandBus): Response
    {
        if ($this->isCsrfTokenValid('disable'.$id, $request->request->get('_token'))) {
            $commandBus->dispatch(new DisableBookCommand(new BookId($id)));

            $this->addFlash('success', 'record disabled');
        }

        return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
    }
}
