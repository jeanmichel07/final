<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    public function findTem($candidat){
        return $this->createQueryBuilder('v')
            ->andHaving('v.candidat = :val')
            ->setParameter('val', $candidat)
            ->orderBy('v.id', 'DESC')
            ->getQuery()
            ->getResult();
    }


    public function searchVideoCVF()
    {
        return $this->createQueryBuilder('v')
            ->where('v.status = :val')
            ->andWhere('v.type = :cv')
            ->setParameter('cv', "CV")
            ->setParameter('val', "0")
            ->getQuery()
            ->getResult();
    }
    public function searchVideoCVT()
    {
        return $this->createQueryBuilder('v')
            ->where('v.status = :vl')
            ->andWhere('v.type = :cv')
            ->setParameter('cv', "CV")
            ->setParameter('vl', "1")
            ->getQuery()
            ->getResult();
    }



    public function searchVideoEntretientf()
    {
        return $this->createQueryBuilder('v')
            ->where('v.status = :val')
            ->andWhere('v.type = :entretient')
            ->setParameter('entretient', "Entretient")
            ->setParameter('val', "0")
            ->getQuery()
            ->getResult();
    }
    public function searchVideoEntretientt()
    {
        return $this->createQueryBuilder('v')
            ->where('v.status = :val')
            ->andWhere('v.type = :entretient')
            ->setParameter('entretient', "Entretient")
            ->setParameter('val', "1")
            ->getQuery()
            ->getResult();
    }



    public function searchVideoCVCandidat($candidat_id)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.candidat = :val')
            ->andWhere('v.type = :cv')
            ->setParameter('val', $candidat_id)
            ->setParameter('cv', "CV")
            ->getQuery()
            ->getResult();
    }

    public function searchVideoEntretientCandidat($candidat_id)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.candidat = :val')
            ->andWhere('v.type = :entretient')
            ->setParameter('val', $candidat_id)
            ->setParameter('entretient', "Entretient")
            ->getQuery()
            ->getResult();
    }
    public function findOne($user)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.candidat = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getResult()
            ;
    }
//
//    public function findVideo($candidat){
//        return $this->createQueryBuilder('t')
//            ->andHaving('t.candidat = :val')
//            ->setParameter('val', $candidat)
//            ->getQuery()
//            ->getResult();
//    }

    // /**
    //  * @return Video[] Returns an array of Video objects
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
    public function findOneBySomeField($value): ?Video
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
