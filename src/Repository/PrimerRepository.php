<?php

namespace App\Repository;

use App\Entity\Primer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Primer>
 *
 * @method Primer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Primer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Primer[]    findAll()
 * @method Primer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrimerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Primer::class);
    }

//    /**
//     * @return Primer[] Returns an array of Primer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Primer
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
