<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Repository;

use CarlosChininin\App\Infrastructure\Repository\BaseRepository;
use CarlosChininin\App\Infrastructure\Security\Security;
use CarlosChininin\Util\Filter\DoctrineValueSearch;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Salud\Webapp\Controller\UsuarioRolController;
use SocialApp\Apps\Salud\Webapp\Entity\UsuarioRol;

/**
 * @method UsuarioRol|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsuarioRol|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsuarioRol[]    findAll()
 * @method UsuarioRol[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioRolRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry, private Security $security)
    {
        parent::__construct($registry, UsuarioRol::class);
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

        $this->security->filterQuery($queryBuilder, UsuarioRolController::BASE_ROUTE, $permissions);

        DoctrineValueSearch::apply($queryBuilder, $params->getNullableString('b'), ['usuarioRol.name']);

        return $queryBuilder;
    }

    public function allQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('usuarioRol')
            ->select(['usuarioRol', 'usuarios', 'config', 'owner'])
            ->leftJoin('usuarioRol.users', 'usuarios')
            ->leftJoin('usuarioRol.config', 'config')
            ->leftJoin('usuarioRol.owner', 'owner')
            ->andWhere('usuarioRol.rol <> :roleSuperAdmin OR :isSuperAdmin = true')
            ->setParameter('roleSuperAdmin', Security::ROLE_SUPER_ADMIN)
            ->setParameter('isSuperAdmin', $this->security->isSuperAdmin());
    }
}
