<?php

namespace App\Repository;

use App\Entity\OffreEmplois;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OffreEmplois|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreEmplois|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreEmplois[]    findAll()
 * @method OffreEmplois[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreEmploisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreEmplois::class);
    }

    public function findOffre()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findOffreOne($id)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
            ;
    }
    public function findOnOffre($id)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAcces($user, $offre){
        $em=$this->getEntityManager();
        $query=$em->createQuery('SELECT p FROM App\Entity\OffreEmplois o INNER JOIN App\Entity\Proposition p WITH o.id=p.OffreEmplois INNER JOIN App\Entity\Acces a WITH p.id=a.proposition WHERE a.responsable = :user and o.statu = :val and o.id = :offre GROUP BY a.id')
        ->setParameter('user',$user)
        ->setParameter('val',true)
            ->setParameter('offre', $offre);
        return $query->getResult();
    }
    public function findOffres($user){
        $em=$this->getEntityManager();
        $query=$em->createQuery('SELECT o FROM App\Entity\OffreEmplois o INNER JOIN App\Entity\Proposition p WITH o.id=p.OffreEmplois INNER JOIN App\Entity\Acces a WITH p.id=a.proposition WHERE a.responsable = :user and o.statu = :val GROUP BY o.id')
            ->setParameter('user',$user)
            ->setParameter('val',true);
        return $query->getResult();
    }
    // /**
    //  * @return OffreEmplois[] Returns an array of OffreEmplois objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OffreEmplois
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
