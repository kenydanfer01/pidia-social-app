<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Infrastructure\Doctrine;

use CarlosChininin\Util\Filter\DoctrineValueSearch;
use SocialApp\Demo\BookStore\Domain\Model\Book;
use SocialApp\Demo\BookStore\Domain\Repository\BookRepositoryInterface;
use SocialApp\Demo\BookStore\Domain\ValueObject\Author;
use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Shared\Domain\ValueObject\SearchText;
use SocialApp\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends DoctrineRepository<Book>
 */
final class DoctrineBookRepository extends DoctrineRepository implements BookRepositoryInterface
{
    private const ENTITY_CLASS = Book::class;
    private const ALIAS = 'book';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(Book $book): void
    {
        $this->em->persist($book);
        $this->em->flush();
    }

    public function remove(Book $book): void
    {
        $this->em->remove($book);
        $this->em->flush();
    }

    public function ofId(BookId $id): ?Book
    {
        return $this->em->find(self::ENTITY_CLASS, $id->value);
    }

    public function withSearchText(SearchText $searchText): static
    {
        return $this->filter(static function (QueryBuilder $queryBuilder) use ($searchText): void {
            DoctrineValueSearch::apply($queryBuilder, $searchText->value, [
                'book.author.value',
                'book.name.value',
            ]);
        });
    }

    public function withCheapestsFirst(): static
    {
        return $this->filter(static function (QueryBuilder $qb): void {
            $qb->orderBy(sprintf('%s.price.amount', self::ALIAS), 'ASC');
        });
    }
}
