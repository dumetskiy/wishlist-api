<?php

declare(strict_types=1);

namespace App\Security\OwnershipResolver;

use App\Entity\User;

class UserOwnershipResolver extends BaseOwnershipResolver
{
    /**
     * @param User $object
     *
     * @return User
     */
    public function getOwner($object): User
    {
        return $object;
    }

    /**
     * @return string
     */
    public function getSupportedEntityType(): string
    {
        return User::class;
    }
}