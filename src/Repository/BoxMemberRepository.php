<?php

namespace App\Repository;

use App\Entity\BoxMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BoxMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoxMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoxMember[]    findAll()
 * @method BoxMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoxMemberRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BoxMember::class);
    }

    // /**
    //  * @return BoxMember[] Returns an array of BoxMember objects
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
    public function findOneBySomeField($value): ?BoxMember
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
