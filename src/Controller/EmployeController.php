<?php

namespace App\Controller;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(): Response
    {
        return $this->render('employe/index.html.twig', [
            'controller_name' => 'EmployeController',
        ]);
    }
    #[Route('/employe/reviews', name: 'employe_reviews')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les avis en attente
        $pendingReviews = $entityManager->getRepository(Review::class)->findBy(['status' => 'pending']);

        return $this->render('employe/index.html.twig', [
            'pendingReviews' => $pendingReviews,
        ]);
    }

    #[Route('/employe/review/{id}/approve', name: 'employe_review_approve')]
    public function approve(Review $review, EntityManagerInterface $entityManager): Response
    {
        $review->setStatus('approved');
        $entityManager->flush();

        return $this->redirectToRoute('employe_reviews');
    }

    #[Route('/employe/review/{id}/reject', name: 'employe_review_reject')]
    public function reject(Review $review, EntityManagerInterface $entityManager): Response
    {
        $review->setStatus('rejected');
        $entityManager->flush();

        return $this->redirectToRoute('employe_reviews');
    }

}
