<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Demo\Webapp\BookCategory\Controller;

use SocialApp\Apps\Demo\Webapp\BookCategory\Form\BookCategoryType;
use SocialApp\Demo\BookCategory\Application\Command\UpdateBookCategoryCommand;
use SocialApp\Demo\BookCategory\Application\Query\FindBookCategoryQuery;
use SocialApp\Demo\BookCategory\Domain\Dto\BookCategoryDto;
use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryDescription;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryName;
use SocialApp\Shared\Application\Command\CommandBusInterface;
use SocialApp\Shared\Application\Query\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class UpdateBookCategoryController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/{id}/edit', name: 'book_category_edit', methods: ['GET', 'POST'])]
    public function __invoke(
        Request $request,
        string $id,
    ): Response {
        /** @var BookCategory|null $model */
        $model = $this->queryBus->ask(new FindBookCategoryQuery(new BookCategoryId(Uuid::fromString($id))));
        if (null === $model) {
            return $this->redirectToRoute('book_category_index', [], Response::HTTP_SEE_OTHER);
        }

        $bookCategory = BookCategoryDto::fromModel($model);
        $form = $this->createForm(BookCategoryType::class, $bookCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new UpdateBookCategoryCommand(
                new BookCategoryId($bookCategory->id),
                null !== $bookCategory->name ? new BookCategoryName($bookCategory->name) : null,
                null !== $bookCategory->description ? new BookCategoryDescription($bookCategory->description) : null,
            );

            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('book_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_category/edit.html.twig', [
            'book_category' => $bookCategory,
            'form' => $form->createView(),
        ]);
    }
}
