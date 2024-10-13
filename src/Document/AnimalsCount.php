<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use App\Repository\AnimalsCountRepository;

#[MongoDB\Document(repositoryClass: AnimalsCountRepository::class)]
class AnimalsCount
{
    #[MongoDB\Id]
    private $id;

    #[MongoDB\Field(type: 'int')]
    private $animalId;

    #[MongoDB\Field(type: 'int')]
    private $consultationCount = 0;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAnimalId(): ?int
    {
        return $this->animalId;
    }

    public function setAnimalId(int $animalId): self
    {
        $this->animalId = $animalId;
        return $this;
    }

    public function getConsultationCount(): ?int
    {
        return $this->consultationCount;
    }
    public function setConsultationCount(int $count): self
    {
        $this->consultationCount = $count;
        return $this;
    }

    public function incrementConsultationCount(): self
    {
        $this->consultationCount++;
        return $this;
    }
}
