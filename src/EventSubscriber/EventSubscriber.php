<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\KernelEvent\EventHandler\KernelEventHandlerFactory;
use App\KernelEvent\EventHandler\KernelEventHandlerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class EventSubscriber implements EventSubscriberInterface
{
    /**
     * @var KernelEventHandlerFactory $eventHandlerFactory
     */
    public $eventHandlerFactory;

    /**
     * @param KernelEventHandlerFactory $eventHandlerFactory
     */
    public function __construct(KernelEventHandlerFactory $eventHandlerFactory)
    {
        $this->eventHandlerFactory = $eventHandlerFactory;
    }

    /**
     * @return array[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['handleEvent', EventPriorities::PRE_READ],
        ];
    }

    /**
     * @param KernelEvent $event
     */
    public function handleEvent(KernelEvent $event): void
    {
        $eventHandler = $this->eventHandlerFactory->getHandlerForKernelEvent($event);

        if (!$eventHandler instanceof KernelEventHandlerInterface) {
            return;
        }

        $eventHandler->handleEvent($event);
    }
}
