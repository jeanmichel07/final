<?php

namespace App\Repository;

use App\Entity\CandidatSexe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CandidatSexe|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidatSexe|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidatSexe[]    findAll()
 * @method CandidatSexe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatSexeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidatSexe::class);
    }

    // /**
    //  * @return CandidatSexe[] Returns an array of CandidatSexe objects
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
    public function findOneBySomeField($value): ?CandidatSexe
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
