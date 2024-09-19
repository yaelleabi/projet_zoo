<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class uniqueOpenHour extends Constraint
{
    public $message = 'Cet horaire existe déjà. Voulez-vous le modifier ?';
}
