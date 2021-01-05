<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    /**
     * Récupère toutes les annonces qui seront affiché sur la page d'accueille.
     *
     * @return void
     */
    // public function findAnnonces()
    // {
    //     return $this->createQueryBuilder('a')
    //         ->select('a.annee, a.prix, ma.marque, mo.modele, c.carburant, p.emplacement')
    //         ->join('a.marque', 'ma')
    //         ->join('a.modele', 'mo')
    //         ->join('a.carburant', 'c')
    //         ->join('a.photos', 'p')
    //         ->where('p.estPrincipal = 1')
    //         ->orderBy('a.createdAt', 'DESC')
    //         ->getQuery()
    //         ->getResult()
    //     ;  
    // }

    public function findAnnonces(
        ?string $marque, ?string $modele, ?string $carburant, ?int $min_year, ?int $max_year, 
        ?int $min_km, ?int $max_km, ?int $min_price, ?int $max_price
    )
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('
            a.annee, 
            a.prix, 
            a.kilometrage, 
            ma.marque, 
            mo.modele, 
            c.carburant, 
            p.emplacement
        ');
        $qb->join('a.marque', 'ma')
           ->join('a.modele', 'mo')
           ->join('a.carburant', 'c')
           ->join('a.photos', 'p')
           ->where('p.estPrincipal = 1');
        if(!empty($marque))
           $qb->andWhere('ma.marque LIKE :marque')
              ->setParameter("marque", $marque);
        if(!empty($modele))
           $qb->andWhere('mo.modele LIKE :modele')
              ->setParameter("modele", $modele);
        if(!empty($carburant))
           $qb->andWhere('c.carburant LIKE :carburant')
              ->setParameter("carburant", $carburant);
        if( ! (empty($min_year) && empty($max_year)))
           $qb->andWhere('a.annee BETWEEN :min_year AND :max_year')
              ->setParameter('min_year', $min_year)
              ->setParameter('max_year', $max_year);
        if( ! (empty($min_price) && empty($max_price)))
            $qb->andWhere('a.prix BETWEEN :min_price AND :max_price')
            ->setParameter("min_price", $min_price)
            ->setParameter("max_price", $max_price);
        if( ! (empty($min_km) && empty($max_km)))
           $qb->andWhere('a.kilometrage BETWEEN :min_km AND :max_km')
              ->setParameter("min_km", $min_km)
              ->setParameter("max_km", $max_km);
        $qb->orderBy('a.createdAt', 'DESC');
        return $qb->getQuery()->getResult();  
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
