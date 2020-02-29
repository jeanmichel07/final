<?php

namespace App\Repository;

use App\Entity\WpPosts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method WpPosts|null find($id, $lockMode = null, $lockVersion = null)
 * @method WpPosts|null findOneBy(array $criteria, array $orderBy = null)
 * @method WpPosts[]    findAll()
 * @method WpPosts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WpPostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WpPosts::class);
    }
    public function finPosts()
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.postStatus = :val')
            ->setParameter('val','publish')
            ->orderBy('w.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return WpPosts[] Returns an array of WpPosts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WpPosts
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
