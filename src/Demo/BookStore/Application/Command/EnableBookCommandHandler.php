<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Demo\BookStore\Domain\Exception\MissingBookException;
use SocialApp\Demo\BookStore\Domain\Model\Book;
use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;

final class EnableBookCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository
    ) {
    }

    public function __invoke(EnableBookCommand $command): Book
    {
        $book = $this->bookRepository->ofId($command->id);
        if (null === $book) {
            throw new MissingBookException($command->id);
        }

        $book->enable();

        $this->bookRepository->save($book);

        return $book;
    }
}
