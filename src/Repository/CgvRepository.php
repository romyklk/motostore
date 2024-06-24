<?php

namespace App\Repository;

use App\Entity\Cgv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cgv>
 *
 * @method Cgv|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cgv|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cgv[]    findAll()
 * @method Cgv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CgvRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cgv::class);
    }

    //    /**
    //     * @return Cgv[] Returns an array of Cgv objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Cgv
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
