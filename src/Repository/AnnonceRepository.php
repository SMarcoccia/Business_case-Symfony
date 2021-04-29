<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Boolean;

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
     * Récupère le nombre d'annonces.
     *
     * @return void
     */
    public function findNbAds(){
        return $this
            ->createQueryBuilder('a')
            ->select('count(a)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Récupère toutes les annonces qui seront affiché sur la page d'accueille.
     *
     * @return void
     */
    public function findListAds(string $page, int $resultPerPages)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('
            a.id,
            a.annee, 
            a.prix, 
            ma.marque, 
            mo.modele, 
            p.emplacement AS photos
        ');
        $qb->leftjoin('a.marque', 'ma')
           ->leftjoin('a.modele', 'mo')
           ->leftjoin('a.photos', 'p')
           ->where('p.estPrincipal = 1');
        $qb->orderBy('a.createdAt', 'DESC');
        $qb->setFirstResult(($page-1) * $resultPerPages);
        $qb->setMaxResults($resultPerPages);

        return $qb->getQuery()->getResult();  
    }

    /**
     * Undocumented function
     *
     * @param string $page
     * @param integer $resultPerPages
     * @param integer $isPagination
     * @param string|null $marqueId
     * @param string|null $modele
     * @param string|null $carburant
     * @param integer|null $min_year
     * @param integer|null $max_year
     * @param integer|null $min_kms
     * @param integer|null $max_kms
     * @param integer|null $min_price
     * @param integer|null $max_price
     * @return array[]
     */
    public function findAdResearched(
        string $page, 
        int $resultPerPages,
        int $isPagination,
        ?string $marqueId, 
        ?string $modele, 
        ?string $carburant, 
        ?int $min_year,
        ?int $max_year, 
        ?int $min_kms, 
        ?int $max_kms, 
        ?int $min_price, 
        ?int $max_price
    ): array
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('
            a.id,
            a.annee, 
            a.prix, 
            ma.marque, 
            mo.modele, 
            p.emplacement AS photos
        ');

        $qb->join('a.marque', 'ma')
           ->join('a.modele', 'mo')
           ->join('a.carburant', 'c')
           ->join('a.photos', 'p')
           ->where('p.estPrincipal = 1');
        if( ! empty($marqueId))
           $qb->andWhere('ma.id = :marqueId')
              ->setParameter("marqueId", $marqueId);
        if( ! empty($modele))
           $qb->andWhere('mo.modele LIKE :modele')
              ->setParameter("modele", $modele);
        if( ! empty($carburant))
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
        if( ! (empty($min_kms) && empty($max_kms)))
           $qb->andWhere('a.kilometrage BETWEEN :min_kms AND :max_kms')
              ->setParameter("min_kms", $min_kms)
              ->setParameter("max_kms", $max_kms);
              $qb->orderBy('a.createdAt', 'DESC');
        if($isPagination){
            $qb->setFirstResult(($page-1) * $resultPerPages);
            $qb->setMaxResults($resultPerPages);
        }
      
        return $qb->getQuery()->getResult();  
    }
}
