<?php

namespace App\Repository;

use App\Entity\GeneralSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GeneralSettings>
 *
 * @method GeneralSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeneralSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeneralSettings[]    findAll()
 * @method GeneralSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneralSettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GeneralSettings::class);
    }

    //    /**
    //     * @return GeneralSettings[] Returns an array of GeneralSettings objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GeneralSettings
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
