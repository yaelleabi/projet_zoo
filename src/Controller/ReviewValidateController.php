<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReviewValidateController extends AbstractController
{
    #[Route('/review/validate', name: 'app_review_validate')]
    public function index(): Response
    {
        return $this->render('review_validate/index.html.twig', [
            'controller_name' => 'ReviewValidateController',
        ]);
    }
}
