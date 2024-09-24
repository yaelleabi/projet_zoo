<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
// use App\Repository\RapportVeterinaireRepository;
// use App\Entity\RapportVeterinaire;
// use App\Form\RapportVeterinaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
class VeterinaryController extends AbstractController
{
    #[Route('/veterinary', name: 'app_veterinary', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('veterinary/index.html.twig', [
            'controller_name' => 'veterinaryController',
        ]);
    }


}
