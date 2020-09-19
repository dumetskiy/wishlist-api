<?php

declare(strict_types=1);

namespace App\KernelEvent\EventHandler;

use App\Entity\User;
use App\Enum\RoutingAliases;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Security;

class RequestEventHandler implements KernelEventHandlerInterface
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param RequestEvent|KernelEvent $event
     */
    public function handleEvent(KernelEvent $event): void
    {
        $this->resolveMeAlias($event);
    }

    /**
     * @return string
     */
    public function getEventType(): string
    {
        return RequestEvent::class;
    }

    /**
     * This method allows to use "me" instead of user id to get authenticated user's details.
     *
     * @param RequestEvent $event
     */
    private function resolveMeAlias(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (User::class !== $request->attributes->get('_api_resource_class')) {
            return;
        }

        if (RoutingAliases::ALIAS_ME !== $request->attributes->get('id')) {
            return;
        }

        $user = $this->security->getUser();

        if (!$user instanceof User) {
            return;
        }

        $request->attributes->set('id', $user->getId());
    }
}
