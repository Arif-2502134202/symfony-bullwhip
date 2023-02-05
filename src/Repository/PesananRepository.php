<?php

namespace App\Repository;

use App\Entity\Pesanan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pesanan>
 *
 * @method Pesanan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pesanan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pesanan[]    findAll()
 * @method Pesanan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PesananRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pesanan::class);
    }

    public function save(Pesanan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pesanan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
    public function findAllJoin(): array
    {
        return $this->createQueryBuilder('Pesanan')
            ->select('Pesanan.id as id, Pesanan.pemesan as pemesan, barang.nama as nama, Pesanan.jumlah as jumlah, Pesanan.proses as proses')
            ->leftJoin('Pesanan.barang','barang')
            ->orderBy('Pesanan.id', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

//    /**
//     * @return Pesanan[] Returns an array of Pesanan objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pesanan
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
