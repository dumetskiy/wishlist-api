<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CurrentUser extends Constraint
{
    public $message = 'This data can only be accessed by it\'s owner';
}
