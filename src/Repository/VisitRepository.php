<?php

namespace App\Repository;

use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visit>
 */
class VisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }

    //    /**
    //     * @return Visit[] Returns an array of Visit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function findNextVisit()
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.animal', 'a')
            ->addSelect('a')
            ->leftJoin('a.user', 'u')
            ->addSelect('u')
            ->orderBy('v.visit_date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findVisitToNotify()
    {
        $now = new \DateTime();  // Date actuelle
        $futureDate = (new \DateTime())->modify('+15 days');  // Choisir le nombre de jours après aujourd'hui à afficher
    
        return $this->createQueryBuilder('v')
            ->leftJoin('v.animal', 'a')
            ->addSelect('a')
            ->leftJoin('a.user', 'u')
            ->addSelect('u')
            ->where('v.visit_date BETWEEN :now AND :futureDate')
            ->setParameter('now', $now)
            ->setParameter('futureDate', $futureDate)
            ->orderBy('v.visit_date', 'ASC')
            ->getQuery()
            ->getResult();
    }
    

}
