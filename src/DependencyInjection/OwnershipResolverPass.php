<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\Security\OwnershipResolver\OwnershipResolverFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class OwnershipResolverPass implements CompilerPassInterface
{
    const OWNERSHIP_RESOLVER_SERVICE_TAG = 'app.ownership_resolver';

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(OwnershipResolverFactory::class)) {
            return;
        }

        $ownershipResolverFactoryDefinition = $container->findDefinition(OwnershipResolverFactory::class);
        $ownershipResolvers = $container->findTaggedServiceIds(self::OWNERSHIP_RESOLVER_SERVICE_TAG);

        foreach ($ownershipResolvers as $serviceId => $ownershipResolver) {
            $ownershipResolverFactoryDefinition->addMethodCall('addResolver', [new Reference($serviceId)]);
        }
    }
}
