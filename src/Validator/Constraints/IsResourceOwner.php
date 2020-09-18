<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsResourceOwner extends Constraint
{
    public $message = 'This action can only be performed by resource owner: {{ username }}';
}
