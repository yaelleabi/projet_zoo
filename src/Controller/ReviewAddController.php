<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReviewAddController extends AbstractController
{
    #[Route('/review/add', name: 'app_review_add')]
    public function index(): Response
    {
        return $this->render('review_add/index.html.twig', [
            'controller_name' => 'ReviewAddController',
        ]);
    }
}
