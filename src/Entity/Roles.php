<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolesRepository::class)]
class Roles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __toString()
    {
        return $this->id;
    }   

    #[ORM\Column(length: 15)]
    private ?string $name = null;

    #[ORM\Column(length: 35, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'level', targetEntity: Staff::class)]
    private Collection $staffs;

    public function __construct()
    {
        $this->staffs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Staff>
     */
    public function getStaffs(): Collection
    {
        return $this->staffs;
    }

    public function addStaff(Staff $staff): self
    {
        if (!$this->staffs->contains($staff)) {
            $this->staffs->add($staff);
            $staff->setLevel($this);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): self
    {
        if ($this->staffs->removeElement($staff)) {
            // set the owning side to null (unless already changed)
            if ($staff->getLevel() === $this) {
                $staff->setLevel(null);
            }
        }

        return $this;
    }
}
