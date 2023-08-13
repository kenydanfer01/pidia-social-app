<?php

namespace SocialApp\Apps\Financiero\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Financiero\Webapp\Entity\Proyeccion;
use SocialApp\Apps\Financiero\Webapp\Entity\Socio;

/**
 * @method Proyeccion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proyeccion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proyeccion[]    findAll()
 * @method Proyeccion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProyeccionRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proyeccion::class);
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

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['proyeccion.anio']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('proyeccion')
            ->select(['proyeccion', 'socio'])
            ->leftJoin('proyeccion.socio', 'socio');
    }

    /** @return Proyeccion[] */
    public function getAllProyeccionBySocio(Socio $socio): array
    {
        return $this->allQuery()
            ->andWhere('proyeccion.socio = :socio')
            ->setParameter('socio', $socio)
            ->orderBy('proyeccion.anio', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function getAllProyeccionBySocioV2(int $socioId): array
    {
        return $this->allQuery()
            ->andWhere('socio.id= :socioId')
            ->setParameter('socioId', $socioId)
            ->orderBy('proyeccion.updatedAt', 'DESC')
            ->getQuery()->getResult();
    }
}
