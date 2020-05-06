<?php

namespace App\Repository;

use App\Entity\TypeBlog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeBlog|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeBlog|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeBlog[]    findAll()
 * @method TypeBlog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeBlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeBlog::class);
    }

    // /**
    //  * @return TypeBlog[] Returns an array of TypeBlog objects
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
    public function findOneBySomeField($value): ?TypeBlog
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
