<?php

namespace App\Controller;

use App\Document\AnimalsCount;
use App\Repository\AnimalsCountRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AnimalsCountController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/animalsCount', name: 'app_animalsCount')]
     
    public function consultAnimal(int $animalId, AnimalsCountRepository $animalsCountRepository, DocumentManager $dm): JsonResponse
    {
        
        $animalsCountRepository = $animalsCountRepository->findOneByAnimalId($animalId);

        if (!$animalsCountRepository) {
            return new JsonResponse(['error' => 'Animal not found'], 404);
        }

        // Incrémenter le compteur de consultations
        $animalsCountRepository->incrementConsultationCount();

        // Sauvegarder les changements dans MongoDB
        $dm->flush();

        return new JsonResponse(['animalId' => $animalsCountRepository->getAnimalId(), 'consultations' => $animalsCountRepository->getConsultationCount()]);
    }
}
