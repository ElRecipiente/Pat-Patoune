<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $identification_number = null;

    #[ORM\Column]
    private ?int $tatoo_number = null;

    #[ORM\Column(length: 20)]
    private ?string $sex = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $birth_Ãdate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $sterilisation_date = null;

    #[ORM\Column(length: 255)]
    private ?string $breed_type = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $distinctive_marks = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Visit>
     */
    #[ORM\OneToMany(targetEntity: Visit::class, mappedBy: 'animal')]
    private Collection $visits;

    public function __construct()
    {
        $this->visits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIdentificationNumber(): ?int
    {
        return $this->identification_number;
    }

    public function setIdentificationNumber(int $identification_number): static
    {
        $this->identification_number = $identification_number;

        return $this;
    }

    public function getTatooNumber(): ?int
    {
        return $this->tatoo_number;
    }

    public function setTatooNumber(int $tatoo_number): static
    {
        $this->tatoo_number = $tatoo_number;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getBirthÃdate(): ?\DateTimeInterface
    {
        return $this->birth_Ãdate;
    }

    public function setBirthÃdate(\DateTimeInterface $birth_Ãdate): static
    {
        $this->birth_Ãdate = $birth_Ãdate;

        return $this;
    }

    public function getSterilisationDate(): ?\DateTimeInterface
    {
        return $this->sterilisation_date;
    }

    public function setSterilisationDate(?\DateTimeInterface $sterilisation_date): static
    {
        $this->sterilisation_date = $sterilisation_date;

        return $this;
    }

    public function getBreedType(): ?string
    {
        return $this->breed_type;
    }

    public function setBreedType(string $breed_type): static
    {
        $this->breed_type = $breed_type;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getDistinctiveMarks(): ?string
    {
        return $this->distinctive_marks;
    }

    public function setDistinctiveMarks(?string $distinctive_marks): static
    {
        $this->distinctive_marks = $distinctive_marks;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
            $visit->setAnimal($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visit): static
    {
        if ($this->visits->removeElement($visit)) {
            // set the owning side to null (unless already changed)
            if ($visit->getAnimal() === $this) {
                $visit->setAnimal(null);
            }
        }

        return $this;
    }
}
