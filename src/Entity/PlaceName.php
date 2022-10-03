<?php

namespace App\Entity;

use App\Repository\PlaceNameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaceNameRepository::class)]
class PlaceName
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $placeType = null;

    #[ORM\Column]
    private ?float $PlacePrice = null;

    #[ORM\Column(length: 255)]
    private ?string $PlaceID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaceType(): ?string
    {
        return $this->placeType;
    }

    public function setPlaceType(string $placeType): self
    {
        $this->placeType = $placeType;

        return $this;
    }

    public function getPlacePrice(): ?float
    {
        return $this->PlacePrice;
    }

    public function setPlacePrice(float $PlacePrice): self
    {
        $this->PlacePrice = $PlacePrice;

        return $this;
    }

    public function getPlaceID(): ?string
    {
        return $this->PlaceID;
    }

    public function setPlaceID(string $PlaceID): self
    {
        $this->PlaceID = $PlaceID;

        return $this;
    }
}
