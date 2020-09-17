<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\KernelEvent\EventHandler\KernelEventHandlerFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class KernelEventHandlerPass implements CompilerPassInterface
{
    const KERNEL_EVENT_HANDLER_SERVICE_TAG = 'app.kernel_event_handler';

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(KernelEventHandlerFactory::class)) {
            return;
        }

        $eventHandlerFactoryDefinition = $container->findDefinition(KernelEventHandlerFactory::class);
        $eventHandlers = $container->findTaggedServiceIds(self::KERNEL_EVENT_HANDLER_SERVICE_TAG);

        foreach ($eventHandlers as $serviceId => $eventHandler) {
            $eventHandlerFactoryDefinition->addMethodCall('addEventHandler', [new Reference($serviceId)]);
        }
    }
}
