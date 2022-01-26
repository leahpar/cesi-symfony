<?php

namespace App\Repository;

use App\Entity\MicroService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MicroService|null find($id, $lockMode = null, $lockVersion = null)
 * @method MicroService|null findOneBy(array $criteria, array $orderBy = null)
 * @method MicroService[]    findAll()
 * @method MicroService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MicroServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MicroService::class);
    }

    // /**
    //  * @return MicroService[] Returns an array of MicroService objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MicroService
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
