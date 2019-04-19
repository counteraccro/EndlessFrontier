<?php

namespace App\Repository;

use App\Entity\BoxConstraint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BoxConstraint|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoxConstraint|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoxConstraint[]    findAll()
 * @method BoxConstraint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoxConstraintRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BoxConstraint::class);
    }

    // /**
    //  * @return BoxConstraint[] Returns an array of BoxConstraint objects
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
    public function findOneBySomeField($value): ?BoxConstraint
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
