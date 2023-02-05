<?php

namespace App\Entity;

use App\Repository\PesananRepository;
use App\Repository\BarangRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PesananRepository::class)]
class Pesanan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __toString()
    {
        return $this->id;
    }  

    #[ORM\Column(length: 25)]
    private ?string $pemesan = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Barang $barang = null;

    #[ORM\Column]
    private ?int $jumlah = null;

    #[ORM\Column]
    private ?int $proses = null;

    #[ORM\OneToOne(mappedBy: 'pesanan', cascade: ['persist', 'remove'])]
    private ?Produksi $produksi = null;

    #[ORM\OneToOne(mappedBy: 'pesanan', cascade: ['persist', 'remove'])]
    private ?Pengambilan $pengambilan = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPemesan(): ?string
    {
        return $this->pemesan;
    }

    public function setPemesan(string $pemesan): self
    {
        $this->pemesan = $pemesan;

        return $this;
    }

    public function getBarang(): ?Barang
    {
        return $this->barang;
    }

    public function setBarang(?Barang $barang): self
    {
        $this->barang = $barang;

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

    public function getProses(): ?int
    {
        return $this->proses;
    }

    public function setProses(int $proses): self
    {
        $this->proses = $proses;

        return $this;
    }

    public function getProduksi(): ?Produksi
    {
        return $this->produksi;
    }

    public function setProduksi(Produksi $produksi): self
    {
        // set the owning side of the relation if necessary
        if ($produksi->getPesanan() !== $this) {
            $produksi->setPesanan($this);
        }

        $this->produksi = $produksi;

        return $this;
    }

    public function getPengambilan(): ?Pengambilan
    {
        return $this->pengambilan;
    }

    public function setPengambilan(Pengambilan $pengambilan): self
    {
        // set the owning side of the relation if necessary
        if ($pengambilan->getPesanan() !== $this) {
            $pengambilan->setPesanan($this);
        }

        $this->pengambilan = $pengambilan;

        return $this;
    }
}
