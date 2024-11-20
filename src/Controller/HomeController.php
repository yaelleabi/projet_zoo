<?php

namespace App\Controller;

use App\Repository\OpeningHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ServicesRepository;
use App\Repository\HabitatRepository;
use App\Repository\AnimalRepository;
use App\Repository\ReviewRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        ServicesRepository $serviceRepository,
        HabitatRepository $habitatRepository,
        OpeningHoursRepository $openingHoursRepository,
        AnimalRepository $animalRepository,   
        ReviewRepository $reviewRepository,    
    ): Response {
        $services = $serviceRepository->findAll();
        $habitats = $habitatRepository->findAll();
        $openingHours = $openingHoursRepository->findAll();
        $animals = $animalRepository->findAll();
        
        // Utilisation du ReviewRepository pour récupérer les avis approuvés
        $reviews = $reviewRepository->findBy(['status' => 'approved']);

        return $this->render('home/index.html.twig', [
            'services' => $services,
            'habitats' => $habitats,
            'openingHours' => $openingHours,
            'animals' => $animals,
            'reviews' => $reviews
        ]);
    }
}
