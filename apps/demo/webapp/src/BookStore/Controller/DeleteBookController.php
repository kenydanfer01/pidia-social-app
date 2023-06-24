<?php

declare(strict_types=1);

namespace SocialApp\Apps\Demo\Webapp\BookStore\Controller;

use SocialApp\Demo\BookStore\Application\Command\DeleteBookCommand;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Shared\Application\Command\CommandBusInterface;
use SocialApp\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class DeleteBookController extends WebController
{
    #[Route('/{id}/delete', name: 'book_delete', methods: ['POST'])]
    public function __invoke(Uuid $id, CommandBusInterface $commandBus): Response
    {
        $commandBus->dispatch(new DeleteBookCommand(new BookId($id)));

        $this->addFlash('success', 'record deleted');

        return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
    }
}
