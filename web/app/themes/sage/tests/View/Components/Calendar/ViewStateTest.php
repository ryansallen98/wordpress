<?php

declare(strict_types=1);

namespace Tests\View\Components\Calendar;

use App\View\Components\Calendar\ViewState;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;
use TailwindMerge\TailwindMerge;

final class ViewStateTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    /**
     * @return array<string, string>
     */
    private static function calendarClasses(): array
    {
        $path = dirname(__DIR__, 4).'/config/classes/calendar.php';

        return require $path;
    }

    public function test_caption_years_use_effective_min_when_disable_past_and_no_explicit_min(): void
    {
        Carbon::setTestNow('2026-04-15');

        $tw = TailwindMerge::instance();
        $c = self::calendarClasses();

        $state = ViewState::make(
            'single',
            0,
            true,
            null,
            '2026-06-01',
            null,
            null,
            null,
            1,
            'dropdown',
            null,
            [],
            [],
            [],
            true,
            false,
            '',
            $c,
            'en',
            $tw,
        );

        self::assertSame(2026, min($state['captionYears']));
        self::assertContains(2026, $state['captionYears']);
        self::assertSame('2026-04-15', $state['calConfig']['min']);
    }

    public function test_unbounded_min_max_yields_full_caption_year_range(): void
    {
        Carbon::setTestNow('2026-04-08');
        $tw = TailwindMerge::instance();
        $c = self::calendarClasses();

        $state = ViewState::make(
            'single',
            0,
            true,
            null,
            null,
            null,
            null,
            null,
            1,
            'dropdown',
            null,
            [],
            [],
            [],
            false,
            false,
            null,
            $c,
            'en-US',
            $tw,
        );

        self::assertSame(range(1900, 2100), $state['captionYears']);
        self::assertCount(12, $state['captionMonthChoices']);
        self::assertArrayHasKey('themeClasses', $state['calConfig']);
    }
}
