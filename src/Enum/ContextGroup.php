<?php

declare(strict_types=1);

namespace App\Enum;

final class ContextGroup
{
    public const USER_READ = 'user:read';

    public const GUEST_WRITE = 'guest:write';
    public const GUEST_READ = 'guest:read';

    public const OWNER_WRITE = 'owner:write';
    public const OWNER_READ = 'owner:read';
}
