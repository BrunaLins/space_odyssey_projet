<?php

namespace App\Repository;

use App\Entity\Search;
use App\Entity\Sejour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Sejour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sejour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sejour[]    findAll()
 * @method Sejour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SejourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sejour::class);
    }

    // /**
    //  * @return Sejour[] Returns an array of Sejour objects
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
    public function findOneBySomeField($value): ?Sejour
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * fonction de recherche grâce au formulaire
     * @param array $search
     * @return array
     */
    public function findAllTri(array $search): array
    {
dump($search);
        $qb = $this->createQueryBuilder('s');

        if (!empty($search['destination'])) {
            $qb
                ->andWhere('s.destination = :destination')
                ->setParameter('destination', $search['destination'])
            ;

        }

        if (!empty($search['typeHebergement'])) {
            $qb
                ->andWhere('s.type_hebergement = :typeHebergement')
                ->setParameter('typeHebergement', $search['typeHebergement'])
            ;
        }

        return $qb->getQuery()->getResult();


    }
}













