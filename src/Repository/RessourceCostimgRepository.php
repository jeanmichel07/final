<?php

namespace App\Repository;

use App\Entity\RessourceCostimg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RessourceCostimg|null find($id, $lockMode = null, $lockVersion = null)
 * @method RessourceCostimg|null findOneBy(array $criteria, array $orderBy = null)
 * @method RessourceCostimg[]    findAll()
 * @method RessourceCostimg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RessourceCostimgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RessourceCostimg::class);
    }
    public function findRessourceimg()
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function searchTypedaily()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.type = :daily')
            ->setParameter('daily', "Daily quotes")
            ->getQuery()
            ->getResult();
    }
    public function searchTypePro()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.type = :Pro')
            ->setParameter('Pro', "Pro tips")
            ->getQuery()
            ->getResult();

    }

    // /**
    //  * @return RessourceCostimg[] Returns an array of RessourceCostimg objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RessourceCostimg
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
