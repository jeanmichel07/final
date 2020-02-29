<?php

namespace App\Repository;

use App\Entity\Ressource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ressource|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ressource|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ressource[]    findAll()
 * @method Ressource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RessourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ressource::class);
    }
    public function findRessource()
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function searchTypeSS()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.Type = :success')
            ->setParameter('success', "SUCCESS STORY")
            ->getQuery()
            ->getResult();
    }
    public function searchTypeVL()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.Type = :vlog')
            ->setParameter('vlog', "VLOG")
            ->getQuery()
            ->getResult();
    }
    public function searchTypeFact()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.Type = :Fact')
            ->setParameter('Fact', "FACT")
            ->getQuery()
            ->getResult();
    }
    public function searchTypejour()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.Type = :journee')
            ->setParameter('journee', "LA JOURNEE D'UN")
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Ressource[] Returns an array of Ressource objects
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
    public function findOneBySomeField($value): ?Ressource
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
