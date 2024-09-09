<?php

namespace App\Controller;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ReviewAddController extends AbstractController
{   
    #[Route('/reviews', name: 'app_reviews')]
    public function index(EntityManagerInterface $entityManager): Response
    {
      
        $approvedReviews = $entityManager->getRepository(Review::class)->findBy(['status' => 'approved']);

        return $this->render('review/index.html.twig', [
            'approvedReviews' => $approvedReviews,
        ]);
    }

  
 
}

