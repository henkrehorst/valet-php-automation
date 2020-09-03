<?php

namespace App\Repository;

use App\Entity\PhpVersion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhpVersion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhpVersion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhpVersion[]    findAll()
 * @method PhpVersion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhpVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhpVersion::class);
    }

    // /**
    //  * @return PhpVersion[] Returns an array of PhpVersion objects
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
    public function findOneBySomeField($value): ?PhpVersion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return PhpVersion[]
     */
    public function getSupportedOrEolPhpVersions()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.status = :eol OR p.status = :supported')
            ->setParameter('eol', "EOL")
            ->setParameter('supported', "supported")
            ->orderBy("p.minorVersion")
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $version
     * @return PhpVersion|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPhpVersionByVersion($version)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.minorVersion = :version')
            ->setParameter('version', $version)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
