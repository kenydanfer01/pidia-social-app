<?php

namespace SocialApp\Apps\Salud\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Salud\Webapp\Entity\EnfermedadesAsociadas;

/**
 * @method EnfermedadesAsociadas|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnfermedadesAsociadas|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnfermedadesAsociadas[]    findAll()
 * @method EnfermedadesAsociadas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnfermedadesAsociadasRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnfermedadesAsociadas::class);
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

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['enfermedades_asociadas.nombre']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('enfermedades_asociadas')
            ->select(['enfermedades_asociadas']);
    }
}
