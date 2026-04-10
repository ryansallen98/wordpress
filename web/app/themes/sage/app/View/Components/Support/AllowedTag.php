<?php

declare(strict_types=1);

namespace App\View\Components\Support;

/**
 * Resolves a user-provided tag name against an allowlist (button, badge, button-group text, etc.).
 */
final class AllowedTag
{
    /**
     * @param  list<string>  $allowed
     */
    public static function resolve(string $as, array $allowed, string $fallback): string
    {
        return in_array($as, $allowed, true) ? $as : $fallback;
    }
}
