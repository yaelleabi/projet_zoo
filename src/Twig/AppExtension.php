<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\OpeningHours;

class AppExtension extends AbstractExtension
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)

    {
       
        $this->entityManager = $entityManager;
    }
    public function getGlobals(): array
    {
        dump('getGlobals called');

    return [
        'testVariable' => 'This is a test',
    ];
    }

    // public function getGlobals(): array
    // {
    //     $openingHours = $this->entityManager->getRepository(OpeningHours::class)->findAll();
    //     return [
    //         'openingHours' => $openingHours,
    //     ];
    // }

    // 
    public function getFunctions() 
    {
        return [
            new TwigFunction('get_opening_hours', [$this, 'getOpeningHours']),
        ];
    }

    public function getOpeningHours()
    {
        return $this->entityManager->getRepository(OpeningHours::class)->findAll();
    }
}
