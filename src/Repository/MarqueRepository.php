<?php

namespace App\Repository;

use App\Entity\Marque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Marque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marque[]    findAll()
 * @method Marque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marque::class);
    }

    public function findAllModelsByBrand($id){
        
        $qb = $this->createQueryBuilder('m');
        $qb->select('mo.modele')
           ->leftjoin('m.modeles', 'mo')
           ->where('m.id = :id')
           ->setParameter('id', $id)
           ->orderBy('mo.modele');
        return $qb->getQuery()->getResult();
        // pas oublier de faire un git
    }
}
