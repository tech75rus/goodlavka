<?php

namespace App\Repository;

use App\Entity\ProductsCart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductsCart|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductsCart|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductsCart[]    findAll()
 * @method ProductsCart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsCartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductsCart::class);
    }

    // /**
    //  * @return ProductsCart[] Returns an array of ProductsCart objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductsCart
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
