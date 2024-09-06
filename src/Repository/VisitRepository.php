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
        // définir le nombre de jour avant d'envoyer la notif, à modifier dans le .env
        $delai = $_ENV['VISIT_NOTIFICATION_DELAY'] ?? null;
        $notifyDate = (new \DateTime())->modify('+' . $delai . ' days')->setTime(0, 0, 0);

        return $this->createQueryBuilder('v')
            ->leftJoin('v.animal', 'a')
            ->addSelect('a')
            ->leftJoin('a.user', 'u')
            ->addSelect('u')
            ->where('v.visit_date = :notifyDate')
            ->setParameter('notifyDate', $notifyDate)
            ->orderBy('v.visit_date', 'ASC')
            ->getQuery()
            ->getResult();
    }
    

}
