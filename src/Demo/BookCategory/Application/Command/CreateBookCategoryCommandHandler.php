<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Application\Command;

use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookCategory\Domain\Repository\BookCategoryRepositoryInterface;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;

final class CreateBookCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BookCategoryRepositoryInterface $bookCategoryRepository)
    {
    }

    public function __invoke(CreateBookCategoryCommand $command): BookCategory
    {
        $book = new BookCategory(
            $command->name,
            $command->description,
        );

        $this->bookCategoryRepository->save($book);

        return $book;
    }
}
