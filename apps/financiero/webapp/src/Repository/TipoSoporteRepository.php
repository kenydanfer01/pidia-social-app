<?php

namespace SocialApp\Apps\Financiero\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Financiero\Webapp\Entity\TipoCredito;

/**
 * @method TipoCredito|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoCredito|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoCredito[]    findAll()
 * @method TipoCredito[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoCreditoRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoCredito::class);
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

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['tipo_credito.nombre']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('tipo_credito')
            ->select(['tipo_credito']);
    }
}
