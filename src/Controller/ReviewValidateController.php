<?php
 namespace App\Controller;

use App\Entity\Review;  
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewValidateController extends AbstractController
{
    #[Route('/submit-review', name: 'app_submit_review')]
    public function submitReview(Request $request, EntityManagerInterface $entityManager): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //  statut de l'avis en attente
            $review->setStatus('pending');


            // Persister l'avis dans la base de données
            $entityManager->persist($review);
            $entityManager->flush();

            // Ajouter un message flash pour informer l'utilisateur
            $this->addFlash('success', 'Votre avis a été soumis et est en attente de validation.');

            // Rediriger ou afficher la confirmation
            return $this->redirectToRoute('/');
        }

        // Afficher le formulaire d'avis
        return $this->render('review/submit.html.twig', [
            'reviewForm' => $form->createView(),
        ]);
    }
}
