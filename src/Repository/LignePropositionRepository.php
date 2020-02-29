<?php

namespace App\Repository;

use App\Entity\LigneProposition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LigneProposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneProposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneProposition[]    findAll()
 * @method LigneProposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LignePropositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneProposition::class);
    }



    // /**
    //  * @return LigneProposition[] Returns an array of LigneProposition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LigneProposition
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
