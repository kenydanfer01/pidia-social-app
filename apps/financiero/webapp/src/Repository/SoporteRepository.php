<?php

namespace SocialApp\Apps\Financiero\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Financiero\Webapp\Entity\Soporte;
use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\SoporteFilterDto;

/**
 * @method Soporte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Soporte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Soporte[]    findAll()
 * @method Soporte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoporteRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Soporte::class);
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

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['soporte.socio']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('soporte')
            ->select(['soporte', 'socio','tipoSoporte'])
            ->leftJoin('soporte.socio', 'socio')
            ->leftJoin('soporte.tipoSoporte', 'tipoSoporte');
    }

    /** @return Soporte[] */
    public function getAllSoportesBySocio(Socio $socio): array
    {
        return $this->allQuery()
            ->andWhere('soporte.socio = :socio')
            ->setParameter('socio', $socio)
            ->orderBy('soporte.updatedAt', 'DESC')
            ->getQuery()->getResult();
    }

    public function getAllSoportesBySocioV2(int $socioId): array
    {
        return $this->allQuery()
            ->andWhere('socio.id= :socioId')
            ->setParameter('socioId', $socioId)
            ->orderBy('soporte.updatedAt', 'DESC')
            ->getQuery()->getResult();
    }

    public function filterQueryPaginated(SoporteFilterDto $filterDto): QueryBuilder
    {
        $queryBuilder = $this->allQuery();
        if (null !== $filterDto->socio) {
            $queryBuilder
                ->andWhere('socio.id = :socioId')
                ->setParameter('socioId', $filterDto->socio);
        }
        if (null !== $filterDto->tipoSoporte) {
            $queryBuilder
                ->andWhere('tipoSoporte.id = :tipoSoporteId')
                ->setParameter('tipoSoporteId', $filterDto->tipoSoporte);
        }
        return $queryBuilder;
    }

}
