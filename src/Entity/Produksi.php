<?php

namespace App\Entity;

use App\Repository\ProduksiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduksiRepository::class)]
class Produksi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'pesanan', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pesanan $pesanan = null;

    #[ORM\Column]
    private ?int $jumlah = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $leadtime = null;

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

    public function getJumlah(): ?int
    {
        return $this->jumlah;
    }

    public function setJumlah(int $jumlah): self
    {
        $this->jumlah = $jumlah;

        return $this;
    }

    public function getLeadtime(): ?string
    {
        return $this->leadtime;
    }

    public function setLeadtime(?string $leadtime): self
    {
        $this->leadtime = $leadtime;

        return $this;
    }

    public function getNama(): ?string
    {
        return $this->nama;
    }

    public function getBullwhip(): ?string
    {
        return $this->bullwhip;
    }
    public function getParameter(): ?string
    {
        return $this->parameter;
    }

}
