<?php

declare(strict_types=1);

namespace SocialApp\Apps\Demo\Webapp\BookCategory\Controller;

use SocialApp\Apps\Demo\Webapp\BookCategory\Form\BookCategoryType;
use SocialApp\Demo\BookCategory\Application\Command\CreateBookCategoryCommand;
use SocialApp\Demo\BookCategory\Domain\Dto\BookCategoryDto;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryDescription;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryName;
use SocialApp\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateBookCategoryController extends AbstractController
{
    #[Route('/new', name: 'book_category_new', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, CommandBusInterface $commandBus): Response
    {
        $book = new BookCategoryDto();
        $form = $this->createForm(BookCategoryType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new CreateBookCategoryCommand(
                new BookCategoryName($book->name),
                new BookCategoryDescription($book->description),
            );

            $commandBus->dispatch($command);

            return $this->redirectToRoute('book_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_category/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }
}
