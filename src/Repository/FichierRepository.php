<?php

namespace App\Repository;

use App\Entity\Fichier;
use App\Entity\FichierSearch;
use Doctrine\ORM\Query;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Fichier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fichier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fichier[]    findAll()
 * @method Fichier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichierRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Fichier::class);
    }

    // /**
    //  * @return Fichier[] Returns an array of Fichier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
     */

    /*
    public function findOneBySomeField($value): ?Fichier
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
     */
/**
     * @return Fichier[] Returns an array of fichier objects
     */
    
    public function findlastesfichier()
    {
        return
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @return Query
     */
    public function findAllVisibleQuery(FichierSearch $search) : Query
    {
        $query = $this->createQueryBuilder('p');
        if ($search->getModule()) {
            $query = $query->andwhere(' p.module like :module')
                ->setParameter('module', $search->getModule() . '%');
        }


        if ($search->getSpecialite()) {
            $query = $query->andwhere(' p.specialite like  :specialite')
                ->setParameter('specialite', $search->getSpecialite() . '%');
        }
        return $query->getQuery();
    }

    
    /**
     * @return Query
     */
    public function findAllVisibleQuerybyprof(FichierSearch $search,String $nom) : Query
    {
        $query = $this->createQueryBuilder('p');
        $query = $query->andwhere(' p.nom like :nom')
                        ->setParameter('nom', $nom );
        if ($search->getModule()) {
            $query = $query->andwhere(' p.module like :module')
                ->setParameter('module', $search->getModule() . '%');
        }
        if ($search->getSpecialite()) {
            $query = $query->andwhere(' p.specialite like  :specialite')
                ->setParameter('specialite', $search->getSpecialite() . '%');
        }
        return $query->getQuery();
    }

}
