<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventsRepository::class)]
class Events
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $URL = null;

    #[ORM\ManyToOne]
    private ?Type $fk_type = null;

    #[ORM\ManyToOne]
    private ?Managers $fk_manager = null;

    #[ORM\ManyToOne]
    private ?Locations $fk_location = null;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getURL(): ?string
    {
        return $this->URL;
    }

    public function setURL(?string $URL): static
    {
        $this->URL = $URL;

        return $this;
    }

    public function getFkType(): ?Type
    {
        return $this->fk_type;
    }

    public function setFkType(?Type $fk_type): static
    {
        $this->fk_type = $fk_type;

        return $this;
    }

    public function getFkManager(): ?Managers
    {
        return $this->fk_manager;
    }

    public function setFkManager(?Managers $fk_manager): static
    {
        $this->fk_manager = $fk_manager;

        return $this;
    }

    public function getFkLocation(): ?Locations
    {
        return $this->fk_location;
    }

    public function setFkLocation(?Locations $fk_location): static
    {
        $this->fk_location = $fk_location;

        return $this;
    }
}
