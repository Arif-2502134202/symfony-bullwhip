<?php

namespace App\Repository;

use App\Entity\Pengambilan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pengambilan>
 *
 * @method Pengambilan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pengambilan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pengambilan[]    findAll()
 * @method Pengambilan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PengambilanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pengambilan::class);
    }

    public function save(Pengambilan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pengambilan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllJoin(): array
    {
        return $this->createQueryBuilder('Pengambilan')
            ->select('Pengambilan.id as id, Pengambilan.pengambil as pengambil, Barang.nama as namabarang, Pengambilan.jumlah as jumlah')
            ->leftJoin('Pengambilan.pesanan', 'Pesanan')
            ->leftJoin('Pesanan.barang','Barang')
            ->orderBy('Pengambilan.id', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

    public function findAllJoinStock(): array
    {
        return $this->createQueryBuilder('Pengambilan')
            ->select('Barang.nama as namabarang, Pengambilan.jumlahproduksi as jumlahproduksi, Pengambilan.jumlah as jumlahpengambilan')
            ->leftJoin('Pengambilan.pesanan', 'Pesanan')
            ->leftJoin('Pesanan.barang','Barang')
            ->orderBy('Pengambilan.id', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }


//    /**
//     * @return Pengambilan[] Returns an array of Pengambilan objects
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

//    public function findOneBySomeField($value): ?Pengambilan
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
