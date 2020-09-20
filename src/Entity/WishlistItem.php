<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\ContextGroup;
use App\Validator\Constraints\IsResourceOwner;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={ContextGroup::SCOPE_WISHLIST_ITEM_READ}},
 *     denormalizationContext={"groups"={ContextGroup::SCOPE_WISHLIST_ITEM_WRITE}},
 *     collectionOperations={"post"},
 *     itemOperations={"get", "delete"},
 * )
 *
 * @ORM\Entity()
 * @ORM\Table(name="tblWishlistItem")
 */
class WishlistItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="intWishlistItemId", type="integer")
     *
     * @Groups({
     *     ContextGroup::SCOPE_WISHLIST_ITEM_WRITE,
     *     ContextGroup::SCOPE_WISHLIST_ITEM_READ,
     *     ContextGroup::SCOPE_WISHLIST_READ,
     * })
     */
    private $id;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity=Product::class, cascade={"persist"})
     * @ORM\JoinColumn(name="intProductId", referencedColumnName="intProductId", onDelete="SET NULL")
     *
     * @Groups({
     *     ContextGroup::SCOPE_WISHLIST_ITEM_WRITE,
     *     ContextGroup::SCOPE_WISHLIST_ITEM_READ,
     *     ContextGroup::SCOPE_WISHLIST_READ,
     * })
     */
    private $product;

    /**
     * @var Wishlist
     *
     * @ORM\ManyToOne(targetEntity=Wishlist::class, cascade={"persist"}, inversedBy="wishlistItems")
     * @ORM\JoinColumn(name="intWishlistId", referencedColumnName="intWishlistId", onDelete="SET NULL")
     *
     * @Groups({
     *     ContextGroup::SCOPE_WISHLIST_ITEM_WRITE,
     *     ContextGroup::SCOPE_WISHLIST_ITEM_READ,
     * })
     *
     * @IsResourceOwner()
     */
    private $wishlist;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtmCreated", type="datetime")
     *
     * @Assert\NotNull()
     *
     * @Groups({
     *     ContextGroup::SCOPE_WISHLIST_ITEM_READ,
     *     ContextGroup::SCOPE_WISHLIST_READ,
     * })
     */
    private $created;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     *
     * @return $this
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @param \DateTime $created
     *
     * @return $this
     */
    public function setCreated(\DateTime $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return Wishlist|null
     */
    public function getWishlist(): ?Wishlist
    {
        return $this->wishlist;
    }

    /**
     * @param Wishlist $wishlist
     */
    public function setWishlist(Wishlist $wishlist): void
    {
        $this->wishlist = $wishlist;
    }
}
