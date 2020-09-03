<?php

namespace App\Repository;

use App\Entity\PlatformUpdate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlatformUpdate|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlatformUpdate|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlatformUpdate[]    findAll()
 * @method PlatformUpdate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatformUpdateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlatformUpdate::class);
    }

    // /**
    //  * @return PlatformUpdate[] Returns an array of PlatformUpdate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlatformUpdate
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
