<?php

namespace App\Repository;

use App\Entity\CommandeLigne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommandeLigne>
 *
 * @method CommandeLigne|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeLigne|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeLigne[]    findAll()
 * @method CommandeLigne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeLigneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeLigne::class);
    }

    public function findAllThisMonth(): array
    {
        $now = new \DateTime('first day of this month');
        $endOfMonth = new \DateTime('first day of next month');

        return $this->createQueryBuilder('c')
            ->andWhere('c.created_at >= :startOfMonth')
            ->andWhere('c.created_at < :endOfMonth')
            ->setParameter('startOfMonth', $now)
            ->setParameter('endOfMonth', $endOfMonth)
            ->getQuery()
            ->getResult();
    }


    public function findAllThisYear(): array
    {
        $now = new \DateTime('first day of January this year');
        $endOfYear = new \DateTime('first day of January next year');

        return $this->createQueryBuilder('c')
            ->andWhere('c.created_at >= :startOfYear')
            ->andWhere('c.created_at < :endOfYear')
            ->setParameter('startOfYear', $now)
            ->setParameter('endOfYear', $endOfYear)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return CommandeLigne[] Returns an array of CommandeLigne objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CommandeLigne
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
