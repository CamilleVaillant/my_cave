<?php

namespace App\Repository;

use App\Entity\Wine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wine>
 */
class WineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wine::class);
    }

//    /**
//     * @return Wine[] Returns an array of Wine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Wine
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function filterWines(array $criteria): array
    {
        $qb = $this->createQueryBuilder('w');

        if (!empty($criteria['name'])) {
            $qb->andWhere('LOWER(w.name) LIKE LOWER(:name)')
            ->setParameter('name', '%' . strtolower($criteria['name']) . '%');
        }

        if (!empty($criteria['year'])) {
            $qb->andWhere('w.year = :year')
            ->setParameter('year', $criteria['year']);
        }

        if (!empty($criteria['region'])) {
            $qb->andWhere('w.region = :region')
            ->setParameter('region', $criteria['region']);
        }

        if (!empty($criteria['cepage']) && count($criteria['cepage']) > 0) {
            $qb->join('w.cepages', 'c')
            ->andWhere('c.id IN (:cepages)')
            ->setParameter('cepages', array_map(fn($c) => $c->getId(), $criteria['cepage']));
        }

        return $qb->getQuery()->getResult();
    }

}

