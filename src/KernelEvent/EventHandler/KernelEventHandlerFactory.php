<?php

declare(strict_types=1);

namespace App\KernelEvent\EventHandler;

use Symfony\Component\HttpKernel\Event\KernelEvent;

class KernelEventHandlerFactory
{
    /**
     * @var array
     */
    private $eventTypeHandlerMap = [];

    /**
     * @param KernelEventHandlerInterface $kernelEventHandler
     */
    public function addEventHandler(KernelEventHandlerInterface $kernelEventHandler): void
    {
        $this->eventTypeHandlerMap[$kernelEventHandler->getEventType()] = $kernelEventHandler;
    }

    /**
     * @param KernelEvent $event
     *
     * @return KernelEventHandlerInterface|null
     */
    public function getHandlerForKernelEvent(KernelEvent $event): ?KernelEventHandlerInterface
    {
        return $this->eventTypeHandlerMap[get_class($event)] ?? null;
    }
}
