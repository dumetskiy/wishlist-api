<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Security\OwnershipResolver\OwnershipResolverFactory;
use Symfony\Component\Security\Core\Security;

class OwnershipValidator
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var OwnershipResolverFactory
     */
    private $ownershipResolverFactory;

    /**
     * @param Security $security
     * @param OwnershipResolverFactory $ownershipResolverFactory
     */
    public function __construct(
        Security $security,
        OwnershipResolverFactory $ownershipResolverFactory
    ) {
        $this->security = $security;
        $this->ownershipResolverFactory = $ownershipResolverFactory;
    }

    /**
     * @param $object
     *
     * @return bool
     */
    public function isObjectOwnedByCurrentUser($object): bool
    {
        $ownershipResolver = $this->ownershipResolverFactory->getResolverForEntity($object);

        if (!$ownershipResolver || !$ownershipResolver->canHaveOwner()) {
            return false;
        }

        $objectOwner = $ownershipResolver->getOwner($object);

        return $objectOwner instanceof User && $objectOwner->getId() === $this->security->getUser()->getId();
    }
}