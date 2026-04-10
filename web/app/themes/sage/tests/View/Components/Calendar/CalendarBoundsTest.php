<?php

declare(strict_types=1);

namespace Tests\View\Components\Calendar;

use App\View\Components\Calendar\CalendarBounds;
use PHPUnit\Framework\TestCase;

final class CalendarBoundsTest extends TestCase
{
    public function test_disable_past_sets_min_to_today_when_unset(): void
    {
        $r = CalendarBounds::mergeMinMaxWithOptions(null, null, true, false, '2026-04-15');
        self::assertSame('2026-04-15', $r['min']);
        self::assertNull($r['max']);
    }

    public function test_disable_past_keeps_stricter_user_min(): void
    {
        $r = CalendarBounds::mergeMinMaxWithOptions('2026-05-01', null, true, false, '2026-04-15');
        self::assertSame('2026-05-01', $r['min']);
    }

    public function test_disable_past_lifts_user_min_to_today(): void
    {
        $r = CalendarBounds::mergeMinMaxWithOptions('2026-01-01', null, true, false, '2026-04-15');
        self::assertSame('2026-04-15', $r['min']);
    }

    public function test_disable_future_sets_max_to_today_when_unset(): void
    {
        $r = CalendarBounds::mergeMinMaxWithOptions(null, null, false, true, '2026-04-15');
        self::assertNull($r['min']);
        self::assertSame('2026-04-15', $r['max']);
    }

    public function test_disable_future_caps_user_max(): void
    {
        $r = CalendarBounds::mergeMinMaxWithOptions(null, '2026-12-31', false, true, '2026-04-15');
        self::assertSame('2026-04-15', $r['max']);
    }

    public function test_disable_future_keeps_stricter_user_max(): void
    {
        $r = CalendarBounds::mergeMinMaxWithOptions(null, '2026-03-01', false, true, '2026-04-15');
        self::assertSame('2026-03-01', $r['max']);
    }

    public function test_both_flags_today_only_window_when_no_min_max(): void
    {
        $r = CalendarBounds::mergeMinMaxWithOptions(null, null, true, true, '2026-04-15');
        self::assertSame('2026-04-15', $r['min']);
        self::assertSame('2026-04-15', $r['max']);
    }
}
