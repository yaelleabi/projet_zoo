<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ServicesRepository;
use App\Repository\HabitatRepository;
use App\Repository\OpeningHoursRepository;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(
        ServicesRepository $serviceRepository,
        HabitatRepository $habitatRepository,
        OpeningHoursRepository $openingHoursRepository,
       
    ): Response {
        $services = $serviceRepository->findAll();
        $habitats= $habitatRepository->findAll();
        $openingHours=$openingHoursRepository->findAll();

        

        return $this->render('admin/index.html.twig', [
            'services' => $services,
            'habitats' => $habitats,
            'openingHours'=>$openingHours,
            
        ]);
    }
    
}
