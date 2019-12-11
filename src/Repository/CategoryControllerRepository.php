<?php

namespace App\Repository;

use App\Entity\CatController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CatController|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatController|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatController[]    findAll()
 * @method CatController[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryControllerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatController::class);
    }

    // /**
    //  * @return CatController[] Returns an array of CatController objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CatController
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
