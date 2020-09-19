<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\ContextGroup;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={ContextGroup::SCOPE_PRODUCT_READ}},
 *     denormalizationContext={"groups"={ContextGroup::SCOPE_PRODUCT_WRITE}},
 *     collectionOperations={"post", "get"},
 *     itemOperations={"get"},
 * )
 *
 * @ORM\Entity()
 * @ORM\Table(name="tblProduct")
 *
 * @UniqueEntity("name")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="intProductId", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="strName", type="string", length=50, unique=true)
     *
     * @Assert\NotNull()
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Product name cannot be longer than {{ limit }} characters"
     * )
     *
     * @Groups({
     *     ContextGroup::SCOPE_PRODUCT_READ,
     *     ContextGroup::SCOPE_PRODUCT_WRITE,
     *     ContextGroup::SCOPE_WISHLIST_ITEM_READ,
     *     ContextGroup::SCOPE_WISHLIST_READ,
     * })
     */
    private $name;

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
}
