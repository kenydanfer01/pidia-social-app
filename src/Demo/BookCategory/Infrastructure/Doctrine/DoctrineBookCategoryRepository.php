<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Infrastructure\Doctrine;

use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookCategory\Domain\Repository\BookCategoryRepositoryInterface;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryName;
use SocialApp\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends DoctrineRepository<BookCategory>
 */
class DoctrineBookCategoryRepository extends DoctrineRepository implements BookCategoryRepositoryInterface
{
    private const ENTITY_CLASS = BookCategory::class;
    private const ALIAS = 'book';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(BookCategory $book): void
    {
        $this->em->persist($book);
        $this->em->flush();
    }

    public function remove(BookCategory $book): void
    {
        $this->em->remove($book);
        $this->em->flush();
    }

    public function ofId(BookCategoryId $id): ?BookCategory
    {
        return $this->em->find(self::ENTITY_CLASS, $id->value);
    }

    public function withName(BookCategoryName $name): static
    {
        return $this->filter(static function (QueryBuilder $qb) use ($name): void {
            $qb->where(sprintf('%s.name.value = :name', self::ALIAS))->setParameter('name', $name->value);
        });
    }
}
