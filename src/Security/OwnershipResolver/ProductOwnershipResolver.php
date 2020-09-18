<?php

declare(strict_types=1);

namespace App\Security\OwnershipResolver;

use App\Entity\Product;

class ProductOwnershipResolver extends BaseOwnershipResolver
{
    /**
     * @return bool
     */
    public function canHaveOwner(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getSupportedEntityType(): string
    {
        return Product::class;
    }
}
