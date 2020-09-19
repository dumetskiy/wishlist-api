<?php

declare(strict_types=1);

namespace App\Enum;

final class ContextGroup
{
    public const OWNER_WRITE = 'owner:write';
    public const OWNER_READ = 'owner:read';

    public const SCOPE_WISHLIST_WRITE = 'scope:wishlist:write';
    public const SCOPE_WISHLIST_READ = 'scope:wishlist:read';

    public const SCOPE_USER_WRITE = 'scope:user:write';
    public const SCOPE_USER_READ = 'scope:user:read';

    public const SCOPE_WISHLIST_ITEM_WRITE = 'scope:wishlist-item:write';
    public const SCOPE_WISHLIST_ITEM_READ = 'scope:wishlist-item:read';

    public const SCOPE_PRODUCT_WRITE = 'scope:product:write';
    public const SCOPE_PRODUCT_READ = 'scope:product:read';

    public const SCOPE_WISHLIST_EXPORT = 'scope:wishlist-export';
}
