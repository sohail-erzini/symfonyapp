<?php

namespace App\Repository;

use App\Entity\EmployeProjetRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmployeProjetRole>
 *
 * @method EmployeProjetRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeProjetRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeProjetRole[]    findAll()
 * @method EmployeProjetRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeProjetRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeProjetRole::class);
    }

    public function add(EmployeProjetRole $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmployeProjetRole $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EmployeProjetRole[] Returns an array of EmployeProjetRole objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EmployeProjetRole
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
