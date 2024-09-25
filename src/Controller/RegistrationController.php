<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
 use Symfony\Component\Mime\Email;

class RegistrationController extends AbstractController
{
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
            //$user->setRoles([$form->get('roles')->getData()]); // Enveloppe le rôle dans un tableau


            $entityManager->persist($user);
            $entityManager->flush();
             $email = (new Email())
            ->from('josearcadia1012@gmail.com') // Admin email
             ->to($user->getUsername()) // Employee email (make sure User entity has a getEmail() method)
             ->subject('Welcome to Our Company!')
             ->text('Dear employee, your registration has been completed by the admin. Welcome aboard!')
            ->html('<p>Dear employee,</p><p>Your registration has been completed by the admin. Welcome aboard!</p>');

              $mailer->send($email);

           // return $security->login($user, LoginAuthenticator::class, 'main');
           // Dans ton contrôleur
            $this->addFlash('success', 'Votre inscription a été réussie !');

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
