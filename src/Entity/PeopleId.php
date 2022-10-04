<?php

namespace App\Entity;

use App\Repository\PeopleIdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeopleIdRepository::class)]
class PeopleId
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $familyName = null;

    #[ORM\ManyToMany(targetEntity: peopleId::class)]
    private Collection $cityPeople;

    public function __construct()
    {
        $this->cityPeople = new ArrayCollection();
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

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): self
    {
        $this->familyName = $familyName;

        return $this;
    }

    /**
     * @return Collection<int, peopleId>
     */
    public function getCityPeople(): Collection
    {
        return $this->cityPeople;
    }

    public function addCityPerson(peopleId $cityPerson): self
    {
        if (!$this->cityPeople->contains($cityPerson)) {
            $this->cityPeople->add($cityPerson);
        }

        return $this;
    }

    public function removeCityPerson(peopleId $cityPerson): self
    {
        $this->cityPeople->removeElement($cityPerson);

        return $this;
    }
}
