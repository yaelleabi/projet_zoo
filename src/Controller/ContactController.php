<?php

namespace App\Controller;

use App\Repository\OpeningHoursRepository;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(
        Request $request,
        OpeningHoursRepository $openingHoursRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse | Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Vérifier si le formulaire est valide
            if ($form->isValid()) {
                $entityManager->persist($contact);
                $entityManager->flush();

                return new JsonResponse([
                    'success' => true,
                    'message' => 'Votre message a été envoyé avec succès !',
                    'data' => [
                        'title' => $contact->getTitle(),
                        'description' => $contact->getDescription(),
                        'mail' => $contact->getMail(),
                    ],
                ]);
            } else {
                // Si le formulaire n'est pas valide, retourner les erreurs
                $errors = [];
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                }

                return new JsonResponse([
                    'success' => false,
                    'message' => 'Des erreurs ont été détectées dans le formulaire.',
                    'errors' => $errors,
                ]);
            }
        }

        $openingHours = $openingHoursRepository->findAll();


        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->createView(),
            'openingHours' => $openingHours,
            
        ]);
    }
}
