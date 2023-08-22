<?php

namespace SocialApp\Apps\Salud\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Salud\Webapp\Entity\FichaExamenAuxiliarDetalle;

/**
 * @method FichaExamenAuxiliarDetalle|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichaExamenAuxiliarDetalle|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichaExamenAuxiliarDetalle[]    findAll()
 * @method FichaExamenAuxiliarDetalle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichaExamenAuxiliarDetalleRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichaExamenAuxiliarDetalle::class);
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

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['ficha_examen_auxiliar_detalle.id']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('ficha_examen_auxiliar_detalle')
            ->select(['ficha_examen_auxiliar_detalle']);
    }
}
