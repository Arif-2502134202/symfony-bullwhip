<?php

namespace App\Entity;

use App\Repository\BarangRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BarangRepository::class)]
class Barang
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __toString()
    {
        return $this->id;
    }   

    #[ORM\Column(length: 35)]
    private ?string $nama = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNama(): ?string
    {
        return $this->nama;
    }

    public function setNama(string $nama): self
    {
        $this->nama = $nama;

        return $this;
    }

    
}
