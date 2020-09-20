<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\DTO\WishlistExportDTO;
use App\Enum\ContextGroup;
use App\Repository\WishlistRepository;
use App\Validator\Constraints\IsResourceOwner;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={ContextGroup::SCOPE_WISHLIST_READ}},
 *     denormalizationContext={"groups"={ContextGroup::SCOPE_WISHLIST_WRITE}},
 *     collectionOperations={
 *         "post",
 *          "export"={
 *              "method"="GET",
 *              "path"="/wishlists/export",
 *              "pagination_enabled"=false,
 *              "output"=WishlistExportDTO::class,
 *              "normalization_context"={"groups"={ContextGroup::SCOPE_WISHLIST_EXPORT}},
 *          },
 *     },
 *     itemOperations={
 *         "get",
 *         "delete",
 *     },
 * )
 *
 * @ORM\Entity(repositoryClass=WishlistRepository::class)
 * @ORM\Table(name="tblWishlist")
 */
class Wishlist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="intWishlistId", type="integer")
     *
     * @Groups({ContextGroup::SCOPE_WISHLIST_READ, ContextGroup::SCOPE_USER_READ})
     */
    private $id;

    /**
     * @ORM\Column(name="strName", type="string", length=30)
     *
     * @Assert\NotNull()
     * @Assert\Length(
     *      max = 30,
     *      maxMessage = "Wishlist name cannot be longer than {{ limit }} characters",
     * )
     *
     * @Groups({
     *     ContextGroup::SCOPE_WISHLIST_READ,
     *     ContextGroup::SCOPE_WISHLIST_WRITE,
     *     ContextGroup::SCOPE_USER_READ,
     * })
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"persist"}, inversedBy="wishlists")
     * @ORM\JoinColumn(name="intUserId", referencedColumnName="intUserId", onDelete="SET NULL")
     *
     * @IsResourceOwner()
     *
     * @Groups({ContextGroup::SCOPE_WISHLIST_WRITE})
     */
    private $user;

    /**
     * @var PersistentCollection|WishlistItem[]
     *
     * @ORM\OneToMany(targetEntity=WishlistItem::class, mappedBy="wishlist", cascade="persist")
     *
     * @Groups({ContextGroup::SCOPE_WISHLIST_READ})
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
     * @return int
     *
     * @Groups({
     *     ContextGroup::SCOPE_WISHLIST_READ,
     *     ContextGroup::SCOPE_USER_READ,
     *     ContextGroup::SCOPE_WISHLIST_EXPORT,
     * })
     */
    public function getItemsCount(): int
    {
        return $this->getWishlistItems()->count();
    }

    /**
     * @return string|null
     *
     * @Groups({
     *     ContextGroup::SCOPE_WISHLIST_READ,
     *     ContextGroup::SCOPE_WISHLIST_EXPORT,
     * })
     */
    public function getOwnerUsername(): ?string
    {
        return $this->getUser() instanceof User
            ? $this->getUser()->getUsername()
            : null;
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
     * @param WishlistItem[]|PersistentCollection $wishlistItems
     *
     * @return $this
     */
    public function setWishlistItems($wishlistItems): self
    {
        $this->wishlistItems = $wishlistItems;

        return $this;
    }
}
