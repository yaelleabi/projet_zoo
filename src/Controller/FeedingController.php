<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FeedingController extends AbstractController
{
    #[Route('/feeding', name: 'app_feeding')]
    public function index(): Response
    {
        return $this->render('feeding/index.html.twig', [
            'controller_name' => 'FeedingController',
        ]);
    }
}
