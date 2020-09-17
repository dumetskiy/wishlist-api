<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\ContextGroup;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     denormalizationContext={ContextGroup::GUEST_WRITE},
 *     normalizationContext={ContextGroup::GUEST_READ},
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
     * @Groups({ContextGroup::OWNER_WRITE, ContextGroup::GUEST_READ})
     */
    private $name;

    /**
     * IsValidOwner constraint allows to make sure only the owner of the wishlist can modify it
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"all"})
     * @ORM\JoinColumn(name="intUserId", referencedColumnName="intUserId", onDelete="SET NULL")
     */
    private $user;

    /**
     * @var PersistentCollection|Product[]
     *
     * @ORM\ManyToMany(targetEntity=Product::class, cascade={"all"})
     *
     * @ORM\JoinTable(name="tblWishlistProduct",
     *     joinColumns={@ORM\JoinColumn(name="intWishlistId", referencedColumnName="intWishlistId", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="intProductId", referencedColumnName="intProductId", onDelete="SET NULL")}
     * )
     *
     * @Assert\NotNull()
     *
     * @Groups({ContextGroup::GUEST_READ})
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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
     * @return User
     */
    public function getUser(): User
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
     * @return PersistentCollection
     */
    public function getProducts(): PersistentCollection
    {
        return $this->products;
    }

    /**
     * @param array $products
     *
     * @return $this
     */
    public function setProducts(array $products): self
    {
        $this->products = $products;

        return $this;
    }
}
