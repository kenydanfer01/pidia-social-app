<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;

final class DeleteBookCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BookRepositoryInterface $bookRepository)
    {
    }

    public function __invoke(DeleteBookCommand $command): void
    {
        if (null === $book = $this->bookRepository->ofId($command->id)) {
            return;
        }

        $this->bookRepository->remove($book);
    }
}
