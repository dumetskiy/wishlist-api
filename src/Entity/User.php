<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\ContextGroup;
use App\Enum\UserRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={ContextGroup::SCOPE_USER_READ}},
 *     denormalizationContext={"groups"={ContextGroup::SCOPE_USER_WRITE}},
 *     collectionOperations={"post"},
 *     itemOperations={"get"},
 * )
 *
 * @ORM\Entity()
 * @ORM\Table(name="tblUser")
 *
 * @UniqueEntity({"username", "apiKey"})
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="intUserId", type="integer")
     *
     * @Groups({ContextGroup::SCOPE_USER_READ})
     */
    private $id;

    /**
     * This is an API key used to authenticate the user
     * By default fixture-generated users API keys are generated using uuid_create().
     * The serialization context is not set so this field will not be serialized.
     *
     * @var string
     *
     * @ORM\Column(name="strApiKey", type="string", length=50)
     *
     * @Assert\NotNull()
     * @Assert\Length(
     *      max = 36,
     *      maxMessage = "API key size is limited to {{ limit }} characters",
     *      allowEmptyString = false
     * )
     *
     * @Groups({
     *     ContextGroup::OWNER_READ,
     *     ContextGroup::OWNER_WRITE,
     *     ContextGroup::SCOPE_USER_WRITE,
     * })
     */
    private $apiKey;

    /**
     * @ORM\Column(name="strUsername", type="string", length=20)
     *
     * @Assert\NotNull()
     * @Assert\Length(
     *      max = 20,
     *      maxMessage = "Username is limited to {{ limit }} characters",
     *      allowEmptyString = false
     * )
     *
     * @Groups({
     *     ContextGroup::OWNER_WRITE,
     *     ContextGroup::SCOPE_USER_READ,
     *     ContextGroup::SCOPE_USER_WRITE,
     * })
     */
    private $username;

    /**
     * @var ArrayCollection|Wishlist[]
     *
     * @ORM\OneToMany(targetEntity=Wishlist::class, mappedBy="user")
     *
     * @Groups({
     *     ContextGroup::SCOPE_USER_READ
     * })
     */
    private $wishlists;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     *
     * @return $this
     */
    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @param mixed $username
     *
     * @return $this
     */
    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return Wishlist[]|ArrayCollection
     */
    public function getWishlists()
    {
        return $this->wishlists;
    }

    /**
     * @param Wishlist[]|ArrayCollection $wishlists
     */
    public function setWishlists($wishlists): void
    {
        $this->wishlists = $wishlists;
    }

    /**
     * As all users will have same privileges there's no need in actual
     * entity field / db column.
     *
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return [UserRole::ROLE_USER];
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->getApiKey();
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->setApiKey($password);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
    }
}
