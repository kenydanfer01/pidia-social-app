<?php

namespace SocialApp\Apps\Salud\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Salud\Webapp\Entity\FichaExamenAuxiliar;

/**
 * @method FichaExamenAuxiliar|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichaExamenAuxiliar|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichaExamenAuxiliar[]    findAll()
 * @method FichaExamenAuxiliar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichaExamenAuxiliarRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichaExamenAuxiliar::class);
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

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['ficha_examen_auxiliar.id']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('ficha_examen_auxiliar')
            ->select(['ficha_examen_auxiliar', 'ficha_evaluacion', 'examen_auxiliar'])
            ->leftJoin('ficha_examen_auxiliar.fichaEvaluacion', 'ficha_evaluacion')
            ->leftJoin('ficha_examen_auxiliar.examenAuxiliar', 'examen_auxiliar');
    }
}
