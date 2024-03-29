<?php

namespace App\Repository;

use App\Entity\Livrable;
use App\Entity\Phase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livrable>
 *
 * @method Livrable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livrable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livrable[]    findAll()
 * @method Livrable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivrableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livrable::class);
    }

    public function add(Livrable $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Livrable $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Livrable[] Returns an array of Livrable objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    /**
     * @return Livrable[] Returns an array of Phase objects
     */
    public function findliv($value): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.Tache = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()

        ;
    }
}
