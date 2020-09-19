<?php

declare(strict_types=1);

namespace App\Security\OwnershipResolver;

use App\Entity\User;

abstract class BaseOwnershipResolver implements OwnershipResolverInterface
{
    /**
     * @return bool
     */
    public function canHaveOwner(): bool
    {
        return true;
    }

    /**
     * @param $object
     *
     * @return null
     */
    public function getOwner($object): ?User
    {
        return null;
    }
}
