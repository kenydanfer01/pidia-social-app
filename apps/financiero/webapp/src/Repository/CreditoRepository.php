<?php

namespace SocialApp\Apps\Financiero\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Financiero\Webapp\Entity\Credito;
use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\CreditoFilterDto;

/**
 * @method Credito|null find($id, $lockMode = null, $lockVersion = null)
 * @method Credito|null findOneBy(array $criteria, array $orderBy = null)
 * @method Credito[]    findAll()
 * @method Credito[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditoRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credito::class);
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

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['credito.socio']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('credito')
            ->select(['credito', 'socio','tipoCredito'])
            ->leftJoin('credito.socio', 'socio')
            ->leftJoin('credito.tipoCredito', 'tipoCredito');
    }

    /** @return Credito[] */
    public function getAllCreditosBySocio(Socio $socio): array
    {
        return $this->allQuery()
            ->andWhere('credito.socio = :socio')
            ->setParameter('socio', $socio)
            ->orderBy('credito.updatedAt', 'DESC')
            ->getQuery()->getResult();
    }

    public function getAllCreditosBySocioV2(int $socioId): array
    {
        return $this->allQuery()
            ->andWhere('socio.id= :socioId')
            ->setParameter('socioId', $socioId)
            ->orderBy('credito.updatedAt', 'DESC')
            ->getQuery()->getResult();
    }

    public function filterQueryPaginated(CreditoFilterDto $filterDto): QueryBuilder
    {
        $queryBuilder = $this->allQuery();
        if (null !== $filterDto->socio) {
            $queryBuilder
                ->andWhere('socio.id = :socioId')
                ->setParameter('socioId', $filterDto->socio);
        }
        if (null !== $filterDto->tipoCredito) {
            $queryBuilder
                ->andWhere('tipoCredito.id = :tipoCreditoId')
                ->setParameter('tipoCreditoId', $filterDto->tipoCredito);
        }
        return $queryBuilder;
    }

}
