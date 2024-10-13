<?php

namespace App\Service;

use App\Document\AnimalsCount;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Repository\AnimalsCountRepository;

class AnimalsCountService
{
    private $dm;
    private $animalsCountRepository;

    public function __construct(DocumentManager $dm, AnimalsCountRepository $animalsCountRepository)
    {
        $this->dm = $dm;
        $this->animalsCountRepository = $animalsCountRepository;
    }

    public function incrementConsultationCount(int $animalId): AnimalsCount
    {
        // Cherche le document AnimalsCount dans MongoDB pour l'animal donné
        $animalsCount = $this->animalsCountRepository->findOneByAnimalId($animalId);

        if (!$animalsCount) {
            // Si aucun document n'existe pour cet animal, on le crée avec un compteur à 1
            $animalsCount = new AnimalsCount();
            $animalsCount->setAnimalId($animalId);
            $animalsCount->setConsultationCount(1);
            $this->dm->persist($animalsCount);
        } else {
            // Sinon, on incrémente simplement le compteur
            $animalsCount->incrementConsultationCount();
        }

        // Sauvegarde les changements dans MongoDB
        $this->dm->flush();

        return $animalsCount;
    }

    public function getConsultationCount(int $animalId): ?int
    {
        $animalsCount = $this->animalsCountRepository->findOneByAnimalId($animalId);
        return $animalsCount ? $animalsCount->getConsultationCount() : null;
    }
}
