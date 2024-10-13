<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ServicesRepository;
use App\Repository\HabitatRepository;
use App\Repository\OpeningHoursRepository;
use App\Repository\AnimalsCountRepository;
use App\Repository\AnimalRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ODM\MongoDB\DocumentManager;
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(
        ServicesRepository $serviceRepository,
        HabitatRepository $habitatRepository,
        OpeningHoursRepository $openingHoursRepository,
        AnimalsCountRepository $animalsCountRepository,
        AnimalRepository $animalsRepository,
       
    ): Response {
        $services = $serviceRepository->findAll();
        $habitats= $habitatRepository->findAll();
        $openingHours=$openingHoursRepository->findAll();
        $animalsCount=$animalsCountRepository->findAll();
        $animals=$animalsRepository->findAll();
        
        


        

        return $this->render('admin/index.html.twig', [
            'services' => $services,
            'habitats' => $habitats,
            'openingHours'=>$openingHours,
            'animalsCount'=>$animalsCount,
            'animals'=>$animals,
            
        ]);
    }
    public function consultAnimal(int $animalId, AnimalRepository $animalRepository, AnimalsCountRepository $animalsCountRepository, DocumentManager $dm): JsonResponse
    {
    // Cherche l'animal dans la base SQL
    $animal = $animalRepository->findOneByAnimalId($animalId);

    if (!$animal) {
        return new JsonResponse(['error' => 'Animal not found in SQL'], 404);
    }

    // Ensuite, utilise l'animalId pour chercher dans MongoDB
    $animalsCount = $animalsCountRepository->findOneByAnimalId($animalId);

    if (!$animalsCount) {
        return new JsonResponse(['error' => 'AnimalsCount not found in MongoDB'], 404);
    }

    // Incrémenter le compteur de consultations
    $animalsCount->incrementConsultationCount();
    $dm->persist($animalsCount);  // Persister les changements dans MongoDB
    $dm->flush();

    return new JsonResponse([
        'animalName' => $animal->getName(), // Depuis la base SQL
        'consultations' => $animalsCount->getConsultationCount() // Depuis MongoDB
    ]);
}


}
