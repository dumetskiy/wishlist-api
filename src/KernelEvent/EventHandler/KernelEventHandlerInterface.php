<?php

declare(strict_types=1);

namespace App\KernelEvent\EventHandler;

use Symfony\Component\HttpKernel\Event\KernelEvent;

interface KernelEventHandlerInterface
{
    /**
     * @return string
     */
    public function getEventType(): string;

    /**
     * @param KernelEvent $event
     */
    public function handleEvent(KernelEvent $event): void;
}
