<?php

namespace App\Repository;

use App\Entity\Planete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Planete>
 *
 * @method Planete|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planete|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planete[]    findAll()
 * @method Planete[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaneteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planete::class);
    }

    public function save(Planete $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Planete $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllWithGalaxies(): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.galaxie', 'g')
            ->addSelect('g')
            ->getQuery()
            ->getResult()
        ;
    }

}
