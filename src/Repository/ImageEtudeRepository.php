<?php

namespace App\Repository;

use App\Entity\ImageEtude;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageEtude|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageEtude|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageEtude[]    findAll()
 * @method ImageEtude[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageEtudeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageEtude::class);
    }

    // /**
    //  * @return ImageEtude[] Returns an array of ImageEtude objects
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
    public function findOneBySomeField($value): ?ImageEtude
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
