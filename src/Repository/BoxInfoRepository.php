<?php

namespace App\Repository;

use App\Entity\BoxInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BoxInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoxInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoxInfo[]    findAll()
 * @method BoxInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoxInfoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BoxInfo::class);
    }

    // /**
    //  * @return BoxInfo[] Returns an array of BoxInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BoxInfo
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
