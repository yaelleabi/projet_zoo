<?php

namespace App\Controller;

use App\Entity\OpeningHours; // Correction du namespace
use App\Form\OpeningHoursType; // Correction du namespace
use Doctrine\ORM\EntityManagerInterface; // Ajout de l'import
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // Ajout de l'import
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; // Correction de l'import du Route

class OpeningHourController extends AbstractController
{
    #[Route('/opening/hour', name: 'app_opening_hour')]
    public function newHoraire(Request $request, EntityManagerInterface $entityManager): Response
    {
        $openingHours = new OpeningHours(); 

    
        $form = $this->createForm(OpeningHoursType::class, $openingHours);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer l'horaire en base de données
            $entityManager->persist($openingHours); 
            $entityManager->flush();

            // Redirection ou message de succès
            $this->addFlash('success', 'Horaire ajouté avec succès !');
            return $this->redirectToRoute('app_opening_hour');
        }

        // Afficher le formulaire dans la vue
        return $this->render('opening_hour/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
