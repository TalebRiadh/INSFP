<?php

namespace App\Repository;

use App\Entity\News;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }

    // /**
    //  * @return News[] Returns an array of News objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    /**
     * @return News[] Returns an array of News objects
     */
    
    public function findlastesevents()
    {
        return
        $query = $this->createQueryBuilder('p')
            ->andwhere(' p.type=:type')
            ->setParameter('type', "evenement")
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return News[] Returns an array of News objects
     */
    
    public function findlastesnews()
    {
        return
        $query = $this->createQueryBuilder('p')
            ->andwhere(' p.type=:type')
            ->setParameter('type', "nouvelle")
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Query
     */
    public function findAllEvents() : Query
    {
        $query = $this->createQueryBuilder('p');
            $query = $query->andwhere(' p.type=:type')
            ->setParameter('type', "evenement")
            ->orderBy('p.id', 'DESC');
;
        
        return $query->getQuery();
    }

 /**
     * @return Query
     */
    public function findAllNews() : Query
    {
        $query = $this->createQueryBuilder('p');
            $query = $query->andwhere(' p.type=:type')

            ->setParameter('type', "nouvelle")       
            ->orderBy('p.id', 'DESC');

        
        return $query->getQuery();
    }

    /*
    public function findOneBySomeField($value): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
  
}
