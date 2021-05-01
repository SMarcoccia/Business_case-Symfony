<?php

namespace App\Repository;

use App\Entity\CaracteristiqueValeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CaracteristiqueValeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaracteristiqueValeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaracteristiqueValeur[]    findAll()
 * @method CaracteristiqueValeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaracteristiqueValeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaracteristiqueValeur::class);
    }

    // /**
    //  * @return CaracteristiqueValeur[] Returns an array of CaracteristiqueValeur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CaracteristiqueValeur
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
