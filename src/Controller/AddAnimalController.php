<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddAnimalController extends AbstractController
{
    #[Route('/add/animal', name: 'app_add_animal')]
    public function index(): Response
    {
        return $this->render('add_animal/index.html.twig', [
            'controller_name' => 'AddAnimalController',
        ]);
    }
}
