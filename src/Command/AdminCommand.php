<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'create:admin',
    description: 'Create a super admin',
)]
class AdminCommand extends Command
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email of the admin')
            ->addArgument('password', InputArgument::REQUIRED, 'Password of the admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        if (!$email || !$password) {
            $io->error('Email and password are required');
            return Command::FAILURE;
        }

        $user = new User();
        $user->setUsername($email);
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $user->setPassword(password_hash($password, PASSWORD_ARGON2I));
        // register the user
        $entityManager = $this->em;
        $entityManager->persist($user);
        $entityManager->flush();

        $io->success('Admin created successfully, you can now login with your credentials');

        return Command::SUCCESS;
    }
}
