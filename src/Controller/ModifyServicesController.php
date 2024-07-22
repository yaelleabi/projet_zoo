<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModifyServicesController extends AbstractController
{
    #[Route('/modify/services', name: 'app_modify_services')]
    public function index(): Response
    {
        return $this->render('modify_services/index.html.twig', [
            'controller_name' => 'ModifyServicesController',
        ]);
    }
}
