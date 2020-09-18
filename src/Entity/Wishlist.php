<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\ContextGroup;
use App\Validator\Constraints\IsResourceOwner;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={ContextGroup::GUEST_READ}},
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
 * @ORM\Table(name="tblWishlist")
 */
class Wishlist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="intWishlistId", type="integer")
     *
     * @Groups({ContextGroup::GUEST_WRITE, ContextGroup::GUEST_READ})
     */
    private $id;

    /**
     * @ORM\Column(name="strName", type="string", length=30)
     *
     * @Assert\NotNull()
     * @Assert\Length(
     *      max = 30,
     *      maxMessage = "Wishlist name cannot be longer than {{ limit }} characters"
     * )
     *
     * @Groups({ContextGroup::GUEST_WRITE, ContextGroup::GUEST_READ})
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"all"})
     * @ORM\JoinColumn(name="intUserId", referencedColumnName="intUserId", onDelete="SET NULL")
     *
     * @Groups({ContextGroup::GUEST_WRITE})
     *
     * @IsResourceOwner()
     */
    private $user;

    /**
     * @var ArrayCollection|WishlistItem[]
     *
     * @ORM\OneToMany(targetEntity=WishlistItem::class, mappedBy="wishlist")
     *
     * @Groups({ContextGroup::GUEST_READ})
     */
    private $wishlistItems;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return WishlistItem[]|PersistentCollection
     */
    public function getWishlistItems()
    {
        return $this->wishlistItems;
    }

    /**
     * @param WishlistItem[]|ArrayCollection $wishlistItems
     *
     * @return $this
     */
    public function setWishlistItems($wishlistItems): self
    {
        $this->wishlistItems = $wishlistItems;

        return $this;
    }
}
