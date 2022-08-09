<?php

namespace App\Repository;

use App\Entity\DentalDiagram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DentalDiagram>
 *
 * @method DentalDiagram|null find($id, $lockMode = null, $lockVersion = null)
 * @method DentalDiagram|null findOneBy(array $criteria, array $orderBy = null)
 * @method DentalDiagram[]    findAll()
 * @method DentalDiagram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DentalDiagramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DentalDiagram::class);
    }

    public function add(DentalDiagram $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DentalDiagram $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DentalDiagram[] Returns an array of DentalDiagram objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DentalDiagram
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
