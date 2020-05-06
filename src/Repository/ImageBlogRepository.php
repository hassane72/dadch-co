<?php

namespace App\Repository;

use App\Entity\ImageBlog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageBlog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageBlog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageBlog[]    findAll()
 * @method ImageBlog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageBlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageBlog::class);
    }

    // /**
    //  * @return ImageBlog[] Returns an array of ImageBlog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageBlog
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
