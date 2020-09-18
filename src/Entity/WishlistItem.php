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
 *     normalizationContext={"groups"={ContextGroup::GUEST_READ, ContextGroup::OWNER_READ}},
 *     denormalizationContext={"groups"={ContextGroup::GUEST_WRITE, ContextGroup::OWNER_WRITE}},
 *     collectionOperations={
 *         "post"={
 *              "denormalization_context"={"groups"={ContextGroup::GUEST_WRITE, ContextGroup::OWNER_WRITE}},
 *              "normalization_context"={"groups"={ContextGroup::GUEST_READ, ContextGroup::OWNER_READ}},
 *         },
 *     },
 *     itemOperations={
 *         "get"={
 *              "denormalization_context"={"groups"={ContextGroup::GUEST_WRITE}},
 *              "normalization_context"={"groups"={ContextGroup::GUEST_READ}},
 *         },
 *     },
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
     * @Groups({ContextGroup::GUEST_WRITE, ContextGroup::GUEST_READ})
     */
    private $id;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity=Product::class, cascade={"all"})
     * @ORM\JoinColumn(name="intProductId", referencedColumnName="intProductId", onDelete="SET NULL")
     *
     * @Groups({ContextGroup::OWNER_WRITE, ContextGroup::GUEST_READ})
     */
    private $product;

    /**
     * @var Wishlist
     * @ORM\ManyToOne(targetEntity=Wishlist::class, cascade={"all"})
     * @ORM\JoinColumn(name="intWishlistId", referencedColumnName="intWishlistId", onDelete="SET NULL")
     *
     * @Groups({ContextGroup::OWNER_WRITE, ContextGroup::GUEST_READ})
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
     * @Groups({ContextGroup::GUEST_READ})
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
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
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
