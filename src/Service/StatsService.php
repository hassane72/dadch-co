<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;

class StatsService {
    private $manager;

    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }

    public function getStats() {
        $users      = $this->getUsersCount();
        $ads        = $this->getAdsCount();
        $etudes   = $this->getEtudesCount();
        $comments   = $this->getCommentsCount();

        return compact('users', 'ads', 'etudes', 'comments');
    }

    public function getUsersCount() {
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
    }

    public function getAdsCount() {
        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Blog b')->getSingleScalarResult();
    }

    public function getEtudesCount() {
        return $this->manager->createQuery('SELECT COUNT(e) FROM App\Entity\Etude e')->getSingleScalarResult();
    }

    public function getCommentsCount() {
        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')->getSingleScalarResult();
    }

    public function getAdsStats($direction) {
        return $this->manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
            FROM App\Entity\Comment c 
            JOIN c.blog a
            JOIN a.author u
            GROUP BY a
            ORDER BY note ' . $direction
        )
        ->setMaxResults(5)
        ->getResult();
    }

}