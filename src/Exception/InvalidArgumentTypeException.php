<?php

declare(strict_types=1);

namespace App\Exception;

class InvalidArgumentTypeException extends \InvalidArgumentException
{
    /**
     * @param string $valueReference
     * @param string $expectedType
     * @param string $actualType
     *
     * @return static
     */
    public static function create(string $valueReference, string $expectedType, string $actualType): self
    {
        return new self(sprintf(
            'Invalid value supplied for %s. Value of type %s expected, got %s',
            $valueReference,
            $expectedType,
            $actualType
        ));
    }
}
