<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\UserRole;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * This is an API key used to authenticate the user
     * By default fixture-generated users API keys are generated using uuid_create()
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\NotNull()
     * @Assert\Length(
     *      max = 36,
     *      maxMessage = "API key size is limited to {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $apiKey;

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
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->apiKey;
    }

    /**
     * As all users will have same privileges there's no need in actual
     * entity field / db column
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