<?php
namespace App\Repository;

use App\Entity\Raid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 *
 * @method Raid|null find($id, $lockMode = null, $lockVersion = null)
 * @method Raid|null findOneBy(array $criteria, array $orderBy = null)
 * @method Raid[] findAll()
 * @method Raid[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaidRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Raid::class);
    }
    
    /**
     * Surcharge find all
     * {@inheritDoc}
     * @see \Doctrine\ORM\EntityRepository::findAll()
     */
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Dernier raid enregistré
     *
     * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
     */
    public function findLastRaid()
    {
        $qb = $this->createQueryBuilder('r');
        $qb->setMaxResults(1);
        $qb->orderBy('r.id', 'DESC');

        $result = $qb->getQuery()->getResult();

        if (empty($result)) {
            return null;
        } else {
            return $result[0];
        }
    }

    // /**
    // * @return Raid[] Returns an array of Raid objects
    // */
    /*
     * public function findByExampleField($value)
     * {
     * return $this->createQueryBuilder('r')
     * ->andWhere('r.exampleField = :val')
     * ->setParameter('val', $value)
     * ->orderBy('r.id', 'ASC')
     * ->setMaxResults(10)
     * ->getQuery()
     * ->getResult()
     * ;
     * }
     */

    /*
     * public function findOneBySomeField($value): ?Raid
     * {
     * return $this->createQueryBuilder('r')
     * ->andWhere('r.exampleField = :val')
     * ->setParameter('val', $value)
     * ->getQuery()
     * ->getOneOrNullResult()
     * ;
     * }
     */
}
