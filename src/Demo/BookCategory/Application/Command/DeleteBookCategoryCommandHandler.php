<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Application\Command;

use SocialApp\Demo\BookCategory\Domain\Repository\BookCategoryRepositoryInterface;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;

final class DeleteBookCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BookCategoryRepositoryInterface $bookCategoryRepository)
    {
    }

    public function __invoke(DeleteBookCategoryCommand $command): void
    {
        if (null === $bookCategory = $this->bookCategoryRepository->ofId($command->id)) {
            return;
        }

        $this->bookCategoryRepository->remove($bookCategory);
    }
}
