<?php

namespace App\Repository;

use App\Entity\Frigos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Frigos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Frigos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Frigos[]    findAll()
 * @method Frigos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FrigosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Frigos::class);
    }

    // /**
    //  * @return Frigos[] Returns an array of Frigos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Frigos
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
