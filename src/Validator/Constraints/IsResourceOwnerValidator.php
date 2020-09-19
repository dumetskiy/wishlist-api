<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Security\OwnershipValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsResourceOwnerValidator extends ConstraintValidator
{
    /**
     * @var OwnershipValidator
     */
    public $ownershipValidator;

    /**
     * @var EntityManagerInterface
     */
    public $entityManager;

    /**
     * @param OwnershipValidator $ownershipValidator
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(OwnershipValidator $ownershipValidator, EntityManagerInterface $entityManager)
    {
        $this->ownershipValidator = $ownershipValidator;
        $this->entityManager = $entityManager;
    }

    /**
     * @param $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!is_object($value)) {
            return;
        }

        if ($this->ownershipValidator->isObjectOwnedByCurrentUser($value)) {
            return;
        }

        $this
            ->context
            ->buildViolation($constraint->message)
            ->addViolation();
    }
}
