<?php

namespace App\Repository;

use App\Entity\Raid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Raid|null find($id, $lockMode = null, $lockVersion = null)
 * @method Raid|null findOneBy(array $criteria, array $orderBy = null)
 * @method Raid[]    findAll()
 * @method Raid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaidRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Raid::class);
    }

    // /**
    //  * @return Raid[] Returns an array of Raid objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Raid
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
