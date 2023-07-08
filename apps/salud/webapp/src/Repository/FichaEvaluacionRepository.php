<?php

namespace SocialApp\Apps\Salud\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Salud\Webapp\Entity\FichaEvaluacion;

/**
 * @method FichaEvaluacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichaEvaluacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichaEvaluacion[]    findAll()
 * @method FichaEvaluacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichaEvaluacionRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichaEvaluacion::class);
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

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['paciente.nombres', 'paciente.apellidoPaterno', 'paciente.apellidoMaterno']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('ficha_evaluacion')
            ->select(['ficha_evaluacion', 'paciente'])
            ->leftJoin('ficha_evaluacion.paciente', 'paciente');
    }
}
