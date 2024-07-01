<?php

namespace App\Entity;

use App\Repository\VaxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VaxRepository::class)]
class Vax
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $vax_name = null;

    /**
     * @var Collection<int, Visit>
     */
    #[ORM\ManyToMany(targetEntity: Visit::class, mappedBy: 'vax')]
    private Collection $visits;

    public function __construct()
    {
        $this->visits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVaxName(): ?string
    {
        return $this->vax_name;
    }

    public function setVaxName(string $vax_name): static
    {
        $this->vax_name = $vax_name;

        return $this;
    }

    /**
     * @return Collection<int, Visit>
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    public function addVisit(Visit $visit): static
    {
        if (!$this->visits->contains($visit)) {
            $this->visits->add($visit);
            $visit->addVax($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visit): static
    {
        if ($this->visits->removeElement($visit)) {
            $visit->removeVax($this);
        }

        return $this;
    }
}
