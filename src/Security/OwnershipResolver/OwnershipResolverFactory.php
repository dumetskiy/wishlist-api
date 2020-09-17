<?php

declare(strict_types=1);

namespace App\Security\OwnershipResolver;

class OwnershipResolverFactory
{
    /**
     * @var array
     */
    private $entityResolversMap = [];

    /**
     * @param OwnershipResolverInterface $ownershipResolver
     */
    public function addResolver(OwnershipResolverInterface $ownershipResolver): void
    {
        $this->entityResolversMap[$ownershipResolver->getSupportedEntityType()] = $ownershipResolver;
    }

    /**
     * @param Object $object
     *
     * @return OwnershipResolverInterface|null
     */
    public function getResolverForEntity($object): ?OwnershipResolverInterface
    {
        if (!is_object($object)) {
            return null;
        }

        return $this->entityResolversMap[get_class($object)] ?? null;
    }
}
