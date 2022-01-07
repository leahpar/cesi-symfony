<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function search(string $value)
    {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.title like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('p.id', 'ASC')
        ;
        return $query->getQuery()->getResult();
    }
}
