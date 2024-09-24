<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {
        // Crée une nouvelle instance de l'entité Contact
        $contact = new Contact();

        // Crée le formulaire à partir du type ContactType
        $form = $this->createForm(ContactType::class, $contact);

        // Gère la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        // if ($form->isSubmitted() && $form->isValid()) {
           
        // }

        // Rend la vue en passant le formulaire à la vue Twig
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->createView(), // Passe le formulaire à la vue
        ]);
    }
}

