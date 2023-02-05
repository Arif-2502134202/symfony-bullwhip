<?php

namespace App\Repository;

use App\Entity\Produksi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produksi>
 *
 * @method Produksi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produksi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produksi[]    findAll()
 * @method Produksi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduksiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produksi::class);
    }

    public function save(Produksi $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Produksi $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllJoin(): array
    {
        return $this->createQueryBuilder('Produksi')
            ->select('Produksi.id as id, Pesanan.id as pesanan, Pesanan.pemesan as pemesan, Barang.nama as namabarang, Produksi.jumlah as jumlah, Produksi.leadtime as leadtime')
            ->leftJoin('Produksi.pesanan', 'Pesanan')
            ->leftJoin('Pesanan.barang','Barang')
            ->orderBy('Produksi.id', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

    public function findAllJoinProd(): array
    {
        return $this->createQueryBuilder('Produksi')
            ->select('Pesanan.id as id, Pesanan.id as pesanan, Pesanan.pemesan as pemesan, Barang.nama as namabarang, Pesanan.jumlah as jumlahpesanan, Produksi.jumlah as jumlahproduksi')
            ->leftJoin('Produksi.pesanan', 'Pesanan')
            ->leftJoin('Pesanan.barang','Barang')
            ->orderBy('Produksi.id', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

    public function findAllJoinBarang(): array
    {
        return $this->createQueryBuilder('Produksi')
            ->select('Barang.nama as nama')
            ->addSelect('Pesanan.jumlah as jumlahpesanan, Produksi.jumlah as jumlahproduksi, Produksi.leadtime as leadtime')
            ->addSelect('ROUND(STDDEV(Pesanan.jumlah),1) as s_order')
            ->addSelect('ROUND(STDDEV(Produksi.jumlah), 1) as s_demand')
            ->addSelect('ROUND(AVG(Pesanan.jumlah), 1) as mean_order')
            ->addSelect('ROUND(AVG(Produksi.jumlah), 1) as mean_demand')
            ->addSelect('ROUND((STDDEV(Pesanan.jumlah) / AVG(Pesanan.jumlah)),1) as cv_order')
            ->addSelect('ROUND((STDDEV(Produksi.jumlah) / AVG(Produksi.jumlah)),1) as cv_demand')
            ->addSelect('ROUND(
                (
                    (STDDEV(Pesanan.jumlah) / AVG(Pesanan.jumlah)) / (STDDEV(Produksi.jumlah) / AVG(Produksi.jumlah))
                )
                ,3) as bullwhip')
            ->addSelect('ROUND(
                (1 + ((2 * Produksi.leadtime) / 30) + ((2 * POWER(Produksi.leadtime,2)) / (POWER(30,2)))),3) as parameter')
            ->innerJoin('Produksi.pesanan', 'Pesanan')
            ->innerJoin('Pesanan.barang','Barang')
            ->groupBy('Barang.nama')
            ->groupBy('Produksi.leadtime')
            ->orderBy('Barang.nama', 'ASC')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
        ;
    }



//    /**
//     * @return Produksi[] Returns an array of Produksi objects
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

//    public function findOneBySomeField($value): ?Produksi
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
