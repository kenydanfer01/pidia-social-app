<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Security\UserStore\Infrastructure\Doctrine;

use CarlosChininin\Util\Filter\DoctrineValueSearch;
use SocialApp\Security\UserStore\Domain\Model\User;
use SocialApp\Security\UserStore\Domain\Repository\UserRepositoryInterface;
use SocialApp\Security\UserStore\Domain\ValueObject\UserId;
use SocialApp\Security\UserStore\Domain\ValueObject\UserName;
use SocialApp\Shared\Domain\ValueObject\SearchText;
use SocialApp\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends DoctrineRepository<User>
 */
class DoctrineUserRepository extends DoctrineRepository implements UserRepositoryInterface
{
    private const ENTITY_CLASS = User::class;
    private const ALIAS = 'user';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function remove(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function ofId(UserId $id): ?User
    {
        return $this->em->find(self::ENTITY_CLASS, $id->value);
    }

    public function withSearchText(SearchText $searchText): static
    {
        return $this->filter(static function (QueryBuilder $queryBuilder) use ($searchText): void {
            DoctrineValueSearch::apply($queryBuilder, $searchText->value, [
                'user.name.value',
                'user.fullName.value',
            ]);
        });
    }
}
