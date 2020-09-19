<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\ContextGroup;
use Symfony\Component\Serializer\Annotation\Groups;

class WishlistExportDTO
{
    /**
     * @var string
     *
     * @Groups({ContextGroup::SCOPE_WISHLIST_EXPORT})
     */
    private $wishlistTitle;

    /**
     * @var string
     *
     * @Groups({ContextGroup::SCOPE_WISHLIST_EXPORT})
     */
    private $ownerUsername;

    /**
     * @var int
     *
     * @Groups({ContextGroup::SCOPE_WISHLIST_EXPORT})
     */
    private $itemsCount;

    /**
     * @return string
     */
    public function getWishlistTitle(): string
    {
        return $this->wishlistTitle;
    }

    /**
     * @param string $wishlistTitle
     *
     * @return $this
     */
    public function setWishlistTitle(string $wishlistTitle): self
    {
        $this->wishlistTitle = $wishlistTitle;

        return $this;
    }

    /**
     * @return string
     */
    public function getOwnerUsername(): string
    {
        return $this->ownerUsername;
    }

    /**
     * @param string $ownerUsername
     *
     * @return $this
     */
    public function setOwnerUsername(string $ownerUsername): self
    {
        $this->ownerUsername = $ownerUsername;

        return $this;
    }

    /**
     * @return int
     */
    public function getItemsCount(): int
    {
        return $this->itemsCount;
    }

    /**
     * @param int $itemsCount
     *
     * @return $this
     */
    public function setItemsCount(int $itemsCount): self
    {
        $this->itemsCount = $itemsCount;

        return $this;
    }
}
