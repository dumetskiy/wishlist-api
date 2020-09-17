<?php

declare(strict_types=1);

namespace App\Security\OwnershipResolver;

use App\Entity\User;

interface OwnershipResolverInterface
{
    /**
     * @return bool
     */
    public function canHaveOwner(): bool;

    /**
     * @param $object
     *
     * @return User|null
     */
    public function getOwner($object): ?User;

    /**
     * @return string
     */
    public function getSupportedEntityType(): string;
}
