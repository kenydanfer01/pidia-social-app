<?php

declare(strict_types=1);

namespace SocialApp\Apps\Demo\Webapp\BookCategory\Controller;

use SocialApp\Demo\BookCategory\Application\Command\DeleteBookCategoryCommand;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

final class DeleteBookCategoryController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/{id}/delete', name: 'book_category_delete', methods: ['GET'])]
    public function __invoke(Request $request, string $id): Response
    {
        Assert::uuid($id);

        $this->commandBus->dispatch(new DeleteBookCategoryCommand(new BookCategoryId(Uuid::fromString($id))));

        return $this->redirectToRoute('book_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
