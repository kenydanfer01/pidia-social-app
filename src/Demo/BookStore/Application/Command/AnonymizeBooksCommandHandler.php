<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Demo\BookStore\Domain\ValueObject\Author;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;

final class AnonymizeBooksCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BookRepositoryInterface $bookRepository)
    {
    }

    public function __invoke(AnonymizeBooksCommand $command): void
    {
        $books = $this->bookRepository->withoutPagination();

        foreach ($books as $book) {
            $book->update(
                author: new Author($command->anonymizedName)
            );

            $this->bookRepository->save($book);
        }
    }
}
