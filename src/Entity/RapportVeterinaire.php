<?php

namespace App\Entity;

use App\Repository\RapportVeterinaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportVeterinaireRepository::class)]
class RapportVeterinaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $state = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $detail = null;

    #[ORM\ManyToOne(inversedBy: 'rapportVeterinaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $Animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

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

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->Animal;
    }

    public function setAnimal(?Animal $Animal): static
    {
        $this->Animal = $Animal;

        return $this;
    }
}
