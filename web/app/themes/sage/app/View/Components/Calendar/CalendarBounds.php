<?php

declare(strict_types=1);

namespace App\View\Components\Calendar;

use Illuminate\Support\Carbon;

/**
 * Min/max merging for the Shadpine calendar Blade component (`x-calendar`).
 *
 * Lives next to `resources/views/components/calendar/` so the calendar can be copied to
 * other Acorn/Laravel projects as a self-contained bundle (see docs/components/calendar.md).
 */
final class CalendarBounds
{
    /**
     * @return array{min: ?string, max: ?string}
     */
    public static function mergeMinMaxWithOptions(
        ?string $min,
        ?string $max,
        bool $disablePast,
        bool $disableFuture,
        string $todayIso,
    ): array {
        $effectiveMin = self::normalizeOrNull($min);
        $effectiveMax = self::normalizeOrNull($max);
        $today = Carbon::parse($todayIso)->startOfDay();

        if ($disablePast) {
            if ($effectiveMin === null) {
                $effectiveMin = $today->toDateString();
            } else {
                $userMin = Carbon::parse($effectiveMin)->startOfDay();
                $effectiveMin = $userMin->max($today)->toDateString();
            }
        }

        if ($disableFuture) {
            if ($effectiveMax === null) {
                $effectiveMax = $today->toDateString();
            } else {
                $userMax = Carbon::parse($effectiveMax)->startOfDay();
                $effectiveMax = $userMax->min($today)->toDateString();
            }
        }

        return [
            'min' => $effectiveMin,
            'max' => $effectiveMax,
        ];
    }

    private static function normalizeOrNull(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return Carbon::parse($value)->startOfDay()->toDateString();
    }
}
