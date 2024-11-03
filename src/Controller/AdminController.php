<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ServicesRepository;
use App\Repository\HabitatRepository;
use App\Repository\OpeningHoursRepository;
use App\Repository\AnimalsCountRepository;
use App\Repository\AnimalRepository;
use App\Repository\RapportVeterinaireRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        RapportVeterinaireRepository $rapportVeterinaireRepository,
        DocumentManager $dm
    ): Response {
        $services = $serviceRepository->findAll();
        $habitats = $habitatRepository->findAll();
        $openingHours = $openingHoursRepository->findAll();
        $animalsCount = $animalsCountRepository->findAll();
        $animals = $animalRepository->findAll();

        // Gestion des filtres pour les rapports vétérinaires
        $animalId = $request->query->get('animalId');
        $date = $request->query->get('date');

        // Récupérer les rapports vétérinaires en fonction des filtres
        $criteria = [];
        if ($animalId) {
            $criteria['Animal'] = $animalId;
        }
        if ($date) {
            $criteria['date'] = new \DateTime($date);
        }

        $rapportsVeterinaires = $rapportVeterinaireRepository->findBy($criteria, ['date' => 'DESC']);

        return $this->render('admin/index.html.twig', [
            'services' => $services,
            'habitats' => $habitats,
            'openingHours' => $openingHours,
            'animalsCount' => $animalsCount,
            'animals' => $animals,
            'rapportsVeterinaires' => $rapportsVeterinaires,
            'selectedAnimalId' => $animalId,
            'selectedDate' => $date,
        ]);
    }
}
