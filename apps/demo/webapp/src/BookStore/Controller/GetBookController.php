<?php

declare(strict_types=1);

namespace SocialApp\Apps\Demo\Webapp\BookStore\Controller;

use SocialApp\Demo\BookStore\Application\Query\FindBookQuery;
use SocialApp\Demo\BookStore\Domain\Dto\BookDto;
use SocialApp\Demo\BookStore\Domain\Model\Book;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Shared\Application\Query\QueryBusInterface;
use SocialApp\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class GetBookController extends WebController
{
    #[Route('/{id}/show', name: 'book_show', methods: ['GET'])]
    public function __invoke(Uuid $id, QueryBusInterface $queryBus): Response
    {
        /** @var Book|null $model */
        $model = $queryBus->ask(new FindBookQuery(new BookId($id)));

        if (null === $model) {
            return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
        }

        $book = BookDto::fromModel($model);

        return $this->render('book_store/show.html.twig', [
            'book' => $book,
        ]);
    }
}
