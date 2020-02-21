<?php

namespace App\Repository;


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

    public function getBest()
    {
        $entityManager = $this->getEntityManager();
        $rsm = new Query\ResultSetMapping();
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('titre', 'titre');
        $rsm->addScalarResult('moyenne', 'moyenne');

        $query = $entityManager->createNativeQuery('SELECT s.id, s.titre, AVG(c.note) as moyenne FROM sejour s, comment c WHERE s.id = c.sejour_id GROUP BY s.id ORDER BY AVG(c.note) DESC LIMIT 5', $rsm);

        return $query->getArrayResult();
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

        if (!empty($search['duree'])) {
            $qb
                ->andWhere('s.dureedata = :dureedata')
                ->setParameter('dureedata', $search['duree']);
        }

        if (!empty($search['typeHebergement'])) {
            $qb
                ->andWhere('s.type_hebergement = :typeHebergement')
                ->setParameter('typeHebergement', $search['typeHebergement'])
            ;
        }

        if (!empty($search['mois_depart'])) {
            $qb
                ->andWhere('s.mois_depart = :mois_depart')
                ->setParameter('mois_depart', $search['mois_depart'])
            ;
        }


        return $qb->getQuery()->getResult();


    }

    public function findByPremium(bool $premium = false)
    {
        $qb = $this->createQueryBuilder('s');

        if (!$premium) {
            $qb
                ->join('s.destination', 'd')
                ->andWhere('d.destination_premium = :premium')
                ->setParameter('premium', $premium)
            ;
        }

            $qb->addOrderBy('s.mois_depart', 'ASC')
        ;
            // on ne remonte que les 6 premiers resultats
            $qb->setMaxResults(6);

        return $qb->getQuery()->getResult();
    }
}













