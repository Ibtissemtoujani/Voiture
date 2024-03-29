<?php

namespace App\Repository;

use App\Entity\Voiture;
use Doctrine\ORM\Query;
use App\Entity\RechercheVoiture;
use Doctrine\Persistence\ManagerRegistry;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Voiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voiture[]    findAll()
 * @method Voiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

    public function findByPagination(RechercheVoiture $rechercheVoiture) : Query{

        $Request = $this->createQueryBuilder('v');
        if($rechercheVoiture->getMinAnnee()){
            $Request = $Request->andWhere('v.annee >= :min')
            ->setParameter(':min',$rechercheVoiture->getMinAnnee());
        }
        if($rechercheVoiture->getMaxAnnee()){
            $Request = $Request->andWhere('v.annee <= :max')
            ->setParameter(':max',$rechercheVoiture->getMaxAnnee());
        }
        return $Request->getQuery();
    }
    // /**
    //  * @return Voiture[] Returns an array of Voiture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Voiture
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
