<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Application\Command;

use SocialApp\Demo\BookCategory\Domain\Exception\MissingBookCategoryException;
use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookCategory\Domain\Repository\BookCategoryRepositoryInterface;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;

final class UpdateBookCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BookCategoryRepositoryInterface $bookCategoryRepository)
    {
    }

    public function __invoke(UpdateBookCategoryCommand $command): BookCategory
    {
        $bookCategory = $this->bookCategoryRepository->ofId($command->id);
        if (null === $bookCategory) {
            throw new MissingBookCategoryException($command->id);
        }

        $bookCategory->update(
            name: $command->name,
            description: $command->description,
        );

        $this->bookCategoryRepository->save($bookCategory);

        return $bookCategory;
    }
}
