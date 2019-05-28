<?php

namespace App\Repository;

use App\Entity\SpecialiteFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SpecialiteFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialiteFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialiteFormation[]    findAll()
 * @method SpecialiteFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialiteFormationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SpecialiteFormation::class);
    }

    // /**
    //  * @return SpecialiteFormation[] Returns an array of Specialite objects
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

}
