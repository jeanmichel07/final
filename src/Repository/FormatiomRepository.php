<?php

namespace App\Repository;

use App\Entity\Formatiom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Formatiom|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formatiom|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formatiom[]    findAll()
 * @method Formatiom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormatiomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formatiom::class);
    }

    // /**
    //  * @return Formatiom[] Returns an array of Formatiom objects
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
    public function findOneBySomeField($value): ?Formatiom
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
