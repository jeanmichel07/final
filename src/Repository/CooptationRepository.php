<?php

namespace App\Repository;

use App\Entity\Cooptation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cooptation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cooptation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cooptation[]    findAll()
 * @method Cooptation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CooptationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cooptation::class);
    }
    public function findCooptation($idOffre)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.offreEmplois = :val')
            ->setParameter('val', $idOffre)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;

    }

    // /**
    //  * @return Cooptation[] Returns an array of Cooptation objects
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
    public function findOneBySomeField($value): ?Cooptation
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
