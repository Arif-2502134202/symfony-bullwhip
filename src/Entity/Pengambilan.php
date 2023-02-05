<?php

namespace App\Entity;

use App\Repository\PengambilanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PengambilanRepository::class)]
class Pengambilan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'pengambilan', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pesanan $pesanan = null;

    #[ORM\Column(length: 25)]
    private ?string $pengambil = null;

    #[ORM\Column]
    private ?int $jumlah = null;

    #[ORM\Column]
    private ?int $jumlahproduksi = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPesanan(): ?Pesanan
    {
        return $this->pesanan;
    }

    public function setPesanan(Pesanan $pesanan): self
    {
        $this->pesanan = $pesanan;

        return $this;
    }

    public function getPengambil(): ?string
    {
        return $this->pengambil;
    }

    public function setPengambil(string $pengambil): self
    {
        $this->pengambil = $pengambil;

        return $this;
    }

    public function getJumlah(): ?int
    {
        return $this->jumlah;
    }

    public function setJumlah(int $jumlah): self
    {
        $this->jumlah = $jumlah;

        return $this;
    }

    public function getJumlahProduksi(): ?int
    {
        return $this->jumlahproduksi;
    }

    public function setJumlahProduksi(int $jumlahproduksi): self
    {
        $this->jumlahproduksi = $jumlahproduksi;

        return $this;
    }
}
