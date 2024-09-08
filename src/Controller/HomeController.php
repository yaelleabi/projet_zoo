<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ServicesRepository;
use App\Repository\HabitatRepository;


class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        ServicesRepository $serviceRepository,
        HabitatRepository $habitatRepository,
       
    ): Response {
        $services = $serviceRepository->findAll();
        $habitats= $habitatRepository->findAll();
        

        return $this->render('home/index.html.twig', [
            'services' => $services,
            'habitats' => $habitats,
            
        ]);
    }
}
