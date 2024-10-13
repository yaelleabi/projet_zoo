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
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ODM\MongoDB\DocumentManager;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin', methods: ['GET'])]
    public function index(
        Request $request,
        ServicesRepository $serviceRepository,
        HabitatRepository $habitatRepository,
        OpeningHoursRepository $openingHoursRepository,
        AnimalsCountRepository $animalsCountRepository,
        AnimalRepository $animalRepository,
        DocumentManager $dm
    ): Response {
        $services = $serviceRepository->findAll();
        $habitats = $habitatRepository->findAll();
        $openingHours = $openingHoursRepository->findAll();
        $animalsCount = $animalsCountRepository->findAll();
        $animals = $animalRepository->findAll();

        // Vérifier si un paramètre 'animalId' est présent dans la requête pour incrémenter le compteur
        $animalId = $request->query->get('animalId');
        if ($animalId) {
            // Chercher l'animal dans la base SQL
            $animal = $animalRepository->find($animalId);

            if (!$animal) {
                return new JsonResponse(['error' => 'Animal not found in SQL'], 404);
            }

            // Chercher le document AnimalsCount correspondant dans MongoDB
            $animalCount = $animalsCountRepository->findOneBy(['animalId' => $animalId]);

            if (!$animalCount) {
                // Si le document n'existe pas encore, le créer
                $animalCount = new \App\Document\AnimalsCount();
                $animalCount->setAnimalId($animalId);
                $animalCount->setConsultationCount(1);
                $dm->persist($animalCount);
            } else {
                // Si le document existe, on incrémente le compteur
                $animalCount->incrementConsultationCount();
            }

            // Sauvegarder les modifications dans MongoDB
            $dm->flush();

            // Retourner les données de consultation en JSON pour la requête AJAX ou autre
            return new JsonResponse([
                'animalName' => $animal->getName(),
                'consultations' => $animalCount->getConsultationCount(),
            ]);
        }

        // Si aucun 'animalId' n'est fourni, on affiche la page d'administration
        return $this->render('admin/index.html.twig', [
            'services' => $services,
            'habitats' => $habitats,
            'openingHours' => $openingHours,
            'animalsCount' => $animalsCount,
            'animals' => $animals,
        ]);
    }
}
