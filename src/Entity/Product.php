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
 * @ApiResource()
 *
 * @ORM\Entity()
 * @ORM\Table(name="tblProduct")
 *
 * @UniqueEntity("strName")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="intProductId", type="integer")
     *
     * @Groups({ContextGroup::USER_READ})
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
     * @Groups({ContextGroup::USER_READ})
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
