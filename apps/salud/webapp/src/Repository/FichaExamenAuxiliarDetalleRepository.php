<?php

namespace SocialApp\Apps\Salud\Webapp\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Salud\Webapp\Entity\FichaExamenAuxiliarDetalle;

/**
 * @extends ServiceEntityRepository<FichaExamenAuxiliarDetalle>
 *
 * @method FichaExamenAuxiliarDetalle|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichaExamenAuxiliarDetalle|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichaExamenAuxiliarDetalle[]    findAll()
 * @method FichaExamenAuxiliarDetalle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichaExamenAuxiliarDetalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichaExamenAuxiliarDetalle::class);
    }

    public function save(FichaExamenAuxiliarDetalle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FichaExamenAuxiliarDetalle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FichaExamenAuxiliarDetalle[] Returns an array of FichaExamenAuxiliarDetalle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FichaExamenAuxiliarDetalle
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
