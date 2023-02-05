<?php

namespace App\Entity;

use App\Repository\StaffRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StaffRepository::class)]
class Staff
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $kode = null;

    #[ORM\Column(length: 35)]
    private ?string $name = null;

    #[ORM\Column(length: 35, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 25)]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'staffs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Roles $level = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKode(): ?string
    {
        return $this->kode;
    }

    public function setKode(string $kode): self
    {
        $this->kode = $kode;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getLevel(): ?Roles
    {
        return $this->level;
    }

    public function setLevel(?Roles $level): self
    {
        $this->level = $level;

        return $this;
    }
}
