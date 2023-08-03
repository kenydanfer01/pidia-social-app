<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Financiero\Webapp\Entity\ConfigMenu;

/**
 * @method ConfigMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfigMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfigMenu[]    findAll()
 * @method ConfigMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigMenuRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfigMenu::class);
    }

    public function filter(array|ParamFetcher $params, bool $inArray = true, array $permissions = []): array
    {
        $queryBuilder = $this->filterQuery($params, $permissions);

        if (true === $inArray) {
            return $queryBuilder->getQuery()->getArrayResult();
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function filterQuery(array|ParamFetcher $params, array $permissions = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('configMenu')
            ->select('configMenu')
            ->orderBy('configMenu.name', 'ASC');

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['configMenu.name']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('configMenu')
            ->select('configMenu');
    }
}
