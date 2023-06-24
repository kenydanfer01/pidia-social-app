<?php

declare(strict_types=1);

namespace SocialApp\Apps\Demo\Webapp\BookCategory\Controller;

use SocialApp\Demo\BookCategory\Application\Query\FindBookCategoryQuery;
use SocialApp\Demo\BookCategory\Domain\Dto\BookCategoryDto;
use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Shared\Application\Query\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class GetBookCategoryController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    #[Route('/{id}/show', name: 'book_category_show', methods: ['GET'])]
    public function __invoke(string $id): Response
    {
        /** @var BookCategory|null $model */
        $model = $this->queryBus->ask(new FindBookCategoryQuery(new BookCategoryId(Uuid::fromString($id))));

        if (null === $model) {
            return $this->redirectToRoute('book_category_index', [], Response::HTTP_SEE_OTHER);
        }

        $bookCategory = BookCategoryDto::fromModel($model);

        return $this->render('book_category/show.html.twig', [
            'book_category' => $bookCategory,
        ]);
    }
}
