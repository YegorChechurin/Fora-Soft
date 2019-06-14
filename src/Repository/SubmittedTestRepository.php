<?php

namespace App\Repository;

use App\Entity\SubmittedTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SubmittedTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubmittedTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubmittedTest[]    findAll()
 * @method SubmittedTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubmittedTestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SubmittedTest::class);
    }

    // /**
    //  * @return SubmittedTest[] Returns an array of SubmittedTest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubmittedTest
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
