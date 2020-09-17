<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Entity\User;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class CurrentUserValidator extends ConstraintValidator
{
    public $message = 'This data can only be accessed by it\'s owner';

    /**
     * @param User $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (
            $value instanceof User
            && $this->security->getUser() instanceof User
            && $value->getId() === $this->security->getId()
        ) {
            return;
        }

        $this->context->buildViolation($constraint->message)->addViolation();
    }
}
