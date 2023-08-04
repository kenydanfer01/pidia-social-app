<?php

namespace SocialApp\Apps\Financiero\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Financiero\Webapp\Entity\BaseSocial;

/**
 * @method BaseSocial|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseSocial|null findOneBy(array $criteria, array $orderBy = null)
 * @method BaseSocial[]    findAll()
 * @method BaseSocial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseSocialRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BaseSocial::class);
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
        $queryBuilder = $this->allQuery();

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['base_social.nombre']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('base_social')
            ->select(['base_social']);
    }
}
