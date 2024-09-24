<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 255)]
    private ?string $race = null;

    

    #[ORM\ManyToOne(inversedBy: 'animal')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Habitat $Habitat = null;

    /**
     * @var Collection<int, AnimalFeeding>
     */
    #[ORM\OneToMany(targetEntity: AnimalFeeding::class, mappedBy: 'animal')]
    private Collection $animalFeedings;

    /**
     * @var Collection<int, RapportVeterinaire>
     */
    #[ORM\OneToMany(targetEntity: RapportVeterinaire::class, mappedBy: 'Animal')]
    private Collection $rapportVeterinaires;

    public function __construct()
    {
        $this->animalFeedings = new ArrayCollection();
        $this->rapportVeterinaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): static
    {
        $this->race = $race;

        return $this;
    }

    
    public function getHabitat(): ?Habitat
    {
        return $this->Habitat;
    }

    public function setHabitat(?Habitat $Habitat): static
    {
        $this->Habitat = $Habitat;

        return $this;
    }

    /**
     * @return Collection<int, AnimalFeeding>
     */
    public function getAnimalFeedings(): Collection
    {
        return $this->animalFeedings;
    }

    public function addAnimalFeeding(AnimalFeeding $animalFeeding): static
    {
        if (!$this->animalFeedings->contains($animalFeeding)) {
            $this->animalFeedings->add($animalFeeding);
            $animalFeeding->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalFeeding(AnimalFeeding $animalFeeding): static
    {
        if ($this->animalFeedings->removeElement($animalFeeding)) {
            // set the owning side to null (unless already changed)
            if ($animalFeeding->getAnimal() === $this) {
                $animalFeeding->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RapportVeterinaire>
     */
    public function getRapportVeterinaires(): Collection
    {
        return $this->rapportVeterinaires;
    }

    public function addRapportVeterinaire(RapportVeterinaire $rapportVeterinaire): static
    {
        if (!$this->rapportVeterinaires->contains($rapportVeterinaire)) {
            $this->rapportVeterinaires->add($rapportVeterinaire);
            $rapportVeterinaire->setAnimal($this);
        }

        return $this;
    }

    public function removeRapportVeterinaire(RapportVeterinaire $rapportVeterinaire): static
    {
        if ($this->rapportVeterinaires->removeElement($rapportVeterinaire)) {
            // set the owning side to null (unless already changed)
            if ($rapportVeterinaire->getAnimal() === $this) {
                $rapportVeterinaire->setAnimal(null);
            }
        }

        return $this;
    }
}
