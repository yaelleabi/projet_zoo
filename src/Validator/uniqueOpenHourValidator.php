<?php
namespace App\Validator;

use App\Entity\OpeningHours;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;


class uniqueOpenHourValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint): void
    {
        dump($value); 
        if (null === $value || '' === $value) {
            return;
        }

        // Logique de validation : recherche dans la base de données
        $existingOpeninghour = $this->em->getRepository(OpeningHours::class)->findOneBy([
            'day' => $value->getday(),
        
        ]);

        if ($existingOpeninghour) {
            // Ajouter une violation si un horaire existe déjà
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
