<?php

namespace App\Controller;

use App\Entity\OpeningHours;
use App\Form\OpeningHours1Type;
use App\Repository\OpeningHoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/opening/hours')]
class OpeningHoursController extends AbstractController
{
    #[Route('/', name: 'app_opening_hours_index', methods: ['GET'])]
    public function index(OpeningHoursRepository $openingHoursRepository): Response
    {
        return $this->render('opening_hours/index.html.twig', [
            'opening_hours' => $openingHoursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_opening_hours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $openingHour = new OpeningHours();
        $form = $this->createForm(OpeningHours1Type::class, $openingHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($openingHour);
            $entityManager->flush();

            return $this->redirectToRoute('app_opening_hours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('opening_hours/new.html.twig', [
            'opening_hour' => $openingHour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_opening_hours_show', methods: ['GET'])]
    public function show(OpeningHours $openingHour): Response
    {
        return $this->render('opening_hours/show.html.twig', [
            'opening_hour' => $openingHour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_opening_hours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OpeningHours $openingHour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OpeningHours1Type::class, $openingHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_opening_hours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('opening_hours/edit.html.twig', [
            'opening_hour' => $openingHour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_opening_hours_delete', methods: ['POST'])]
    public function delete(Request $request, OpeningHours $openingHour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$openingHour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($openingHour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_opening_hours_index', [], Response::HTTP_SEE_OTHER);
    }
}
