<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class RegistrationController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles($form->get('roles')->getData());


            $entityManager->persist($user);
            $entityManager->flush();
        
             $email = (new Email())
            ->from('josearcadia1012@gmail.com') // Admin email
            ->to($user->getUsername()) 
            ->subject('Bienvenue au zoo arcadia!')
            ->text('cher employé votre inscription a été effectuée!');
             $mailer->send($email);
            $this->addFlash('success', 'Votre inscription a été réussie !');

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
