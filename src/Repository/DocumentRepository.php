<?php

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function findDoc(){
        return $this->createQueryBuilder('d')
            ->orderBy('d.id','DESC')
            ->getQuery()
            ->getResult();
    }

    public function findbook()
    {
        $query= $this->createQueryBuilder('d')
            ->where('d.type = :val')
            ->setParameter('val','Ebook')
            ->getQuery();
        return $query->getResult();
    }
    public function findbrochure()
    {
        $query= $this->createQueryBuilder('d')
            ->where('d.type = :val')
            ->setParameter('val','Brochure')
            ->getQuery();
        return $query->getResult();
    }

    public function findOneDoc($id){
        $query=$this->createQueryBuilder('d')
            ->where('d.id = :val')
            ->setParameter('val',$id)
            ->getQuery();
        return $query->getResult();
    }
    // /**
    //  * @return Document[] Returns an array of Document objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Document
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
