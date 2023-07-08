<?php

namespace SocialApp\Apps\Salud\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Salud\Webapp\Entity\EnfermedadAsociada;

/**
 * @method EnfermedadAsociada|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnfermedadAsociada|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnfermedadAsociada[]    findAll()
 * @method EnfermedadAsociada[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnfermedadAsociadaRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnfermedadAsociada::class);
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

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['enfermedad_asociada.nombre']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('enfermedad_asociada')
            ->select(['enfermedad_asociada']);
    }
}
