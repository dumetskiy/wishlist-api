<?php

declare(strict_types=1);

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\WishlistExportDTO;
use App\Entity\Wishlist;

class WishlistExportDataTransformer implements DataTransformerInterface
{
    /**
     * @param Wishlist $object
     * @param string $to
     * @param array $context
     *
     * @return WishlistExportDTO
     */
    public function transform($object, string $to, array $context = []): WishlistExportDTO
    {
        return (new WishlistExportDTO())
            ->setItemsCount($object->getItemsCount())
            ->setOwnerUsername($object->getOwnerUsername())
            ->setWishlistTitle($object->getName());
    }

    /**
     * @param array|object $data
     * @param string $to
     * @param array $context
     *
     * @return bool
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof Wishlist && $to === WishlistExportDTO::class;
    }
}
