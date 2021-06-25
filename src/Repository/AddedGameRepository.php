<?php

namespace App\Repository;

use App\Entity\AddedGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AddedGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method AddedGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method AddedGame[]    findAll()
 * @method AddedGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddedGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddedGame::class);
    }

    // /**
    //  * @return AddedGame[] Returns an array of AddedGame objects
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
    public function findOneBySomeField($value): ?AddedGame
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
