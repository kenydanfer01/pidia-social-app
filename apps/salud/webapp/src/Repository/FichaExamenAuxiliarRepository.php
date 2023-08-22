<?php

namespace SocialApp\Apps\Salud\Webapp\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SocialApp\Apps\Salud\Webapp\Entity\FichaExamenAuxiliar;

/**
 * @extends ServiceEntityRepository<FichaExamenAuxiliar>
 *
 * @method FichaExamenAuxiliar|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichaExamenAuxiliar|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichaExamenAuxiliar[]    findAll()
 * @method FichaExamenAuxiliar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichaExamenAuxiliarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichaExamenAuxiliar::class);
    }

    public function save(FichaExamenAuxiliar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FichaExamenAuxiliar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FichaExamenAuxiliar[] Returns an array of FichaExamenAuxiliar objects
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

//    public function findOneBySomeField($value): ?FichaExamenAuxiliar
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
