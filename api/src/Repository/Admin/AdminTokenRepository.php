<?php

namespace App\Repository\Admin;

use App\Entity\Admin\AdminToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminToken[]    findAll()
 * @method AdminToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminToken::class);
    }

    // /**
    //  * @return AdminToken[] Returns an array of AdminToken objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdminToken
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
