<?php

declare(strict_types=1);

namespace SocialApp\Apps\Demo\Webapp\BookStore\Controller;

use SocialApp\Apps\Demo\Webapp\BookStore\Form\BookType;
use SocialApp\Demo\BookCategory\Domain\Dto\BookCategoryDto;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Demo\BookStore\Application\Command\CreateBookCommand;
use SocialApp\Demo\BookStore\Domain\Dto\BookDto;
use SocialApp\Demo\BookStore\Domain\ValueObject\Author;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookContent;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookDescription;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookName;
use SocialApp\Demo\BookStore\Domain\ValueObject\Price;
use SocialApp\Shared\Application\Command\CommandBusInterface;
use SocialApp\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class CreateBookController extends WebController
{
    #[Route('/new', name: 'book_new', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, CommandBusInterface $commandBus): Response
    {
        $book = new BookDto();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new CreateBookCommand(
                new BookName($book->name),
                new BookDescription($book->description),
                new Author($book->author),
                new BookContent($book->content),
                new Price($book->price),
                new BookCategoryId($book->category->id),
                array_map(fn (BookCategoryDto $categoryDto) => new BookCategoryId($categoryDto->id), $book->categories),
            );

            $commandBus->dispatch($command);

            $this->addFlash('success', 'record created');

            return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_store/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }
}
