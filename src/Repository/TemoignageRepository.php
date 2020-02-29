<?php

namespace App\Repository;

use App\Entity\Temoignage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Temoignage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temoignage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temoignage[]    findAll()
 * @method Temoignage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemoignageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temoignage::class);
    }

    public function findtem($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.client = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $idClient
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findRowTemoignage($idClient)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t)')
            ->andWhere('t.client = :val')
            ->setParameter('val', $idClient)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findTe()
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.client','c')
            ->addSelect('c')
            ->andWhere('t.client = c.id')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Temoignage[] Returns an array of Temoignage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Temoignage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
