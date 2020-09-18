<?php

declare(strict_types=1);

namespace App\Security\OwnershipResolver;

use App\Entity\User;
use App\Entity\Wishlist;
use App\Entity\WishlistItem;

class WishlistItemOwnershipResolver extends BaseOwnershipResolver
{
    /**
     * @param WishlistItem $object
     *
     * @return User|null
     */
    public function getOwner($object): ?User
    {
        return $object->getWishlist() instanceof Wishlist
            ? $object->getWishlist()->getUser()
            : null;
    }

    /**
     * @return string
     */
    public function getSupportedEntityType(): string
    {
        return WishlistItem::class;
    }
}
