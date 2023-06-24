<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Demo\BookStore\Domain\Exception\MissingBookException;
use SocialApp\Demo\BookStore\Domain\Model\Book;
use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;

final class DisableBookCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository
    ) {
    }

    public function __invoke(DisableBookCommand $command): Book
    {
        $book = $this->bookRepository->ofId($command->id);
        if (null === $book) {
            throw new MissingBookException($command->id);
        }

        $book->disable();

        $this->bookRepository->save($book);

        return $book;
    }
}
