<?php

declare(strict_types=1);

namespace App\Security\OwnershipResolver;

use App\Entity\User;
use App\Entity\Wishlist;

class WishlistOwnershipResolver extends BaseOwnershipResolver
{
    /**
     * @param Wishlist $object
     *
     * @return User
     */
    public function getOwner($object): User
    {
        return $object->getUser();
    }

    /**
     * @return string
     */
    public function getSupportedEntityType(): string
    {
        return Wishlist::class;
    }
}