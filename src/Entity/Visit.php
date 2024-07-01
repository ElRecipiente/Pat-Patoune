<?php

namespace App\Entity;

use App\Repository\VisitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitRepository::class)]
class Visit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $visit_date = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    /**
     * @var Collection<int, Vax>
     */
    #[ORM\ManyToMany(targetEntity: Vax::class, inversedBy: 'visits')]
    private Collection $vax;

    public function __construct()
    {
        $this->vax = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisitDate(): ?\DateTimeInterface
    {
        return $this->visit_date;
    }

    public function setVisitDate(\DateTimeInterface $visit_date): static
    {
        $this->visit_date = $visit_date;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    /**
     * @return Collection<int, Vax>
     */
    public function getVax(): Collection
    {
        return $this->vax;
    }

    public function addVax(Vax $vax): static
    {
        if (!$this->vax->contains($vax)) {
            $this->vax->add($vax);
        }

        return $this;
    }

    public function removeVax(Vax $vax): static
    {
        $this->vax->removeElement($vax);

        return $this;
    }
}
