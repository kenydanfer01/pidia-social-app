<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Demo\BookCategory\Domain\Repository\BookCategoryRepositoryInterface;
use SocialApp\Demo\BookStore\Domain\Model\Book;
use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;

final class CreateBookCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
        private readonly BookCategoryRepositoryInterface $bookCategoryRepository,
    ) {
    }

    public function __invoke(CreateBookCommand $command): Book
    {
        $category = $this->bookCategoryRepository->ofId($command->categoryId);

        $book = new Book(
            $command->name,
            $command->description,
            $command->author,
            $command->content,
            $command->price,
            $category,
        );

        foreach ($command->categoryIds as $categoryId) {
            $category = $this->bookCategoryRepository->ofId($categoryId);
            $book->addCategory($category);
        }

        $this->bookRepository->save($book);

        return $book;
    }
}
