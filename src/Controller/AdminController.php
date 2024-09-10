<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ServicesRepository;
use App\Repository\HabitatRepository;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(
        ServicesRepository $serviceRepository,
        HabitatRepository $habitatRepository,
       
    ): Response {
        $services = $serviceRepository->findAll();
        $habitats= $habitatRepository->findAll();
        

        return $this->render('admin/index.html.twig', [
            'services' => $services,
            'habitats' => $habitats,
            
        ]);
    }
    
}
