<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Document\AnimalsCount;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Repository\AnimalsCountRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/animal')]
class AnimalController extends AbstractController
{ 
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'app_animal_index', methods: ['GET'])]
    public function index(AnimalRepository $animalRepository): Response
    {
        return $this->render('animal/index.html.twig', [
            'animals' => $animalRepository->findAll(),
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]

    #[Route('/new', name: 'app_animal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($animal);
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animal/new.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }
#[Route('/{id}', name: 'app_animal_show', methods: ['GET'])]
public function show(int $id, AnimalRepository $animalRepository, AnimalsCountRepository $animalsCountRepository, DocumentManager $dm): Response
{
    // Chercher l'animal dans la base de données SQL
    $animal = $animalRepository->findOneBy(['id' => $id]);

    if (!$animal) {
        // Si l'animal n'est pas trouvé, on renvoie une réponse JSON d'erreur
        return new JsonResponse(['error' => 'Animal not found in SQL'], 404);
    }

    // Ensuite, utiliser l'animalId pour chercher dans MongoDB
    $animalsCount = $animalsCountRepository->findOneByAnimalId($id);

    if (!$animalsCount) {
        // Si l'animal n'est pas trouvé dans MongoDB, on crée un nouveau document
        $animalsCount = new AnimalsCount();
        $animalsCount->setAnimalId($id);
        $animalsCount->setConsultationCount(1); 
        $dm->persist($animalsCount);  
    } else {
        // Si le document existe déjà, on incrémente le compteur
        $animalsCount->incrementConsultationCount();
    }

    // Sauvegarder les changements dans MongoDB
    $dm->flush();  // Cette ligne est cruciale pour persister dans MongoDB

    // Rendre la vue Twig avec les données de l'animal et le nombre de consultations
    return $this->render('animal/show.html.twig', [
        'animal' => $animal,
        'consultations' => $animalsCount->getConsultationCount(),
    ]);
}

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Animal $animal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animal/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_animal_delete', methods: ['POST'])]
    public function delete(Request $request, Animal $animal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($animal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    }

}
