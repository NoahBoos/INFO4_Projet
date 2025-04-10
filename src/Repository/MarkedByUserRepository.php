<?php

namespace App\Repository;

use App\Entity\MarkedByUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MarkedByUser>
 */
class MarkedByUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarkedByUser::class);
    }

    /**
     * Note pour la correction : Requête DQL généré par ChatGPT.
     * Je suis, cependant, en mesure d'expliquer son fonctionnement puisqu'elle ressemble sensiblement à ce qu'on a pu faire avec $pdo et SQL.
     * @param int $editorId
     * @return array
     */
    public function findByEditorId(int $editorId): array
    {
        return $this->createQueryBuilder('mbu')
            ->join('mbu.book', 'b')
            ->where('b.bookEditor = :editorId')
            ->setParameter('editorId', $editorId)
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return MarkedByUser[] Returns an array of MarkedByUser objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MarkedByUser
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
