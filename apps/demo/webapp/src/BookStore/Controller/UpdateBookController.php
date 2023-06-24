<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Demo\Webapp\BookStore\Controller;

use SocialApp\Apps\Demo\Webapp\BookStore\Form\BookType;
use SocialApp\Demo\BookCategory\Domain\Dto\BookCategoryDto;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Demo\BookStore\Application\Command\UpdateBookCommand;
use SocialApp\Demo\BookStore\Application\Query\FindBookQuery;
use SocialApp\Demo\BookStore\Domain\Dto\BookDto;
use SocialApp\Demo\BookStore\Domain\Model\Book;
use SocialApp\Demo\BookStore\Domain\ValueObject\Author;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookContent;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookDescription;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookName;
use SocialApp\Demo\BookStore\Domain\ValueObject\Price;
use SocialApp\Shared\Application\Command\CommandBusInterface;
use SocialApp\Shared\Application\Query\QueryBusInterface;
use SocialApp\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class UpdateBookController extends WebController
{
    #[Route('/{id}/edit', name: 'book_edit', methods: ['GET', 'POST'])]
    public function __invoke(
        Request $request,
        Uuid $id,
        QueryBusInterface $queryBus,
        CommandBusInterface $commandBus,
    ): Response {
        /** @var Book|null $model */
        $model = $queryBus->ask(new FindBookQuery(new BookId($id)));
        if (null === $model) {
            return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
        }

        $book = BookDto::fromModel($model);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new UpdateBookCommand(
                new BookId($book->id),
                null !== $book->name ? new BookName($book->name) : null,
                null !== $book->description ? new BookDescription($book->description) : null,
                null !== $book->author ? new Author($book->author) : null,
                null !== $book->content ? new BookContent($book->content) : null,
                null !== $book->price ? new Price($book->price) : null,
                null !== $book->category ? new BookCategoryId($book->category->id) : null,
                array_map(fn (BookCategoryDto $categoryDto) => new BookCategoryId($categoryDto->id), $book->categories),
            );

            $commandBus->dispatch($command);

            $this->addFlash('success', 'record updated');

            return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_store/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }
}
