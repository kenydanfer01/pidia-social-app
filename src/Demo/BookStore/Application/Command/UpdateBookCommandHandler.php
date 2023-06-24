<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Demo\BookCategory\Domain\Repository\BookCategoryRepositoryInterface;
use SocialApp\Demo\BookStore\Domain\Exception\MissingBookException;
use SocialApp\Demo\BookStore\Domain\Model\Book;
use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Shared\Application\Command\CommandHandlerInterface;

final class UpdateBookCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
        private readonly BookCategoryRepositoryInterface $bookCategoryRepository,
    ) {
    }

    public function __invoke(UpdateBookCommand $command): Book
    {
        $book = $this->bookRepository->ofId($command->id);
        if (null === $book) {
            throw new MissingBookException($command->id);
        }

        $category = $this->bookCategoryRepository->ofId($command->categoryId);

        $book->update(
            name: $command->name,
            description: $command->description,
            author: $command->author,
            content: $command->content,
            price: $command->price,
            category: $category,
        );

        $book->removeCategoriesNotSelected($command->categoryIds);

        foreach ($command->categoryIds as $categoryId) {
            $category = $this->bookCategoryRepository->ofId($categoryId);
            $book->addCategory($category);
        }

        $this->bookRepository->save($book);

        return $book;
    }
}
