<?php

declare(strict_types=1);

namespace App\View\Components\Calendar;

use Illuminate\Support\Carbon;
use TailwindMerge\TailwindMerge;

/**
 * Builds all variables for {@see \App\View\Components\Calendar}’s Blade view (no markup).
 */
final class ViewState
{
    /**
     * @param  array<int|string, mixed>  $disabled
     * @param  array<string, mixed>  $modifiers
     * @param  array<string, mixed>  $modifiersClassNames
     * @param  array<string, string>  $calendarClasses
     * @return array{
     *     c: array<string, string>,
     *     modeKey: string,
     *     nMonths: int,
     *     captionLayoutKey: string,
     *     calConfig: array<string, mixed>,
     *     rootClass: string,
     *     captionMonthChoices: list<array{value: int, label: string}>,
     *     captionYears: list<int>
     * }
     */
    public static function make(
        string $mode,
        mixed $weekStartsOn,
        mixed $showOutsideDays,
        ?string $month,
        ?string $selected,
        ?string $min,
        ?string $max,
        ?string $locale,
        mixed $numberOfMonths,
        string $captionLayout,
        ?string $timeZone,
        array $disabled,
        array $modifiers,
        array $modifiersClassNames,
        mixed $disablePast,
        mixed $disableFuture,
        ?string $attributesClass,
        array $calendarClasses,
        string $defaultLocale,
        TailwindMerge $tw,
    ): array {
        $c = $calendarClasses;
        $modeKey = in_array($mode, ['single', 'range'], true) ? $mode : 'single';
        $weekStart = (int) $weekStartsOn === 1 ? 1 : 0;
        $showOutside = filter_var($showOutsideDays, FILTER_VALIDATE_BOOLEAN);

        $localeProp = $locale !== null && $locale !== '' ? str_replace('_', '-', $locale) : null;
        $calendarLocaleTag = $localeProp ?? $defaultLocale;

        $nMonths = max(1, min(12, (int) $numberOfMonths));
        $captionLayoutKey = $captionLayout === 'label' ? 'label' : 'dropdown';
        if ($nMonths > 1) {
            $captionLayoutKey = 'label';
        }

        $timeZoneStr = $timeZone !== null && $timeZone !== '' ? $timeZone : null;

        $todayIso = $timeZoneStr !== null
            ? Carbon::now($timeZoneStr)->toDateString()
            : Carbon::today()->toDateString();

        $disablePastFlag = filter_var($disablePast, FILTER_VALIDATE_BOOLEAN);
        $disableFutureFlag = filter_var($disableFuture, FILTER_VALIDATE_BOOLEAN);
        $minStr = $min !== null && $min !== '' ? $min : null;
        $maxStr = $max !== null && $max !== '' ? $max : null;

        $bounds = CalendarBounds::mergeMinMaxWithOptions(
            $minStr,
            $maxStr,
            $disablePastFlag,
            $disableFutureFlag,
            $todayIso,
        );

        $disabledList = array_values(array_filter(array_map(
            static fn ($v) => is_string($v) ? $v : null,
            $disabled,
        )));

        $modifiersForJs = [];
        foreach ($modifiers as $k => $dates) {
            if (! is_string($k) || $k === '') {
                continue;
            }
            $modifiersForJs[$k] = array_values(array_filter(array_map(
                static fn ($d) => is_string($d) ? $d : null,
                is_array($dates) ? $dates : [],
            )));
        }

        $modifiersClassNamesForJs = [];
        foreach ($modifiersClassNames as $k => $cls) {
            if (is_string($k) && is_string($cls) && $cls !== '') {
                $modifiersClassNamesForJs[$k] = $cls;
            }
        }

        $hasMonth = $month !== null && $month !== '';
        $hasSelected = $selected !== null && $selected !== '';

        if ($hasSelected) {
            $visibleMonth = Carbon::parse($selected)->startOfMonth()->toDateString();
        } elseif ($hasMonth) {
            $visibleMonth = Carbon::parse($month)->startOfMonth()->toDateString();
        } else {
            $visibleMonth = Carbon::parse($todayIso)->startOfMonth()->toDateString();
        }

        $calConfig = [
            'mode' => $modeKey,
            'weekStartsOn' => $weekStart,
            'showOutsideDays' => $showOutside,
            'visibleMonth' => $visibleMonth,
            'selected' => $selected,
            'min' => $bounds['min'],
            'max' => $bounds['max'],
            'locale' => $calendarLocaleTag,
            'numberOfMonths' => $nMonths,
            'captionLayout' => $captionLayoutKey,
            'timeZone' => $timeZoneStr,
            'disabled' => $disabledList,
            'modifiers' => $modifiersForJs,
            'modifiersClassNames' => $modifiersClassNamesForJs,
            'themeClasses' => [
                'dayTd' => $c['day_td'],
                'rangeStart' => $c['range_start'],
                'rangeMiddle' => $c['range_middle'],
                'rangeEnd' => $c['range_end'],
                'today' => $c['today'],
                'outside' => $c['outside'],
                'disabled' => $c['disabled'],
            ],
        ];

        $rootClass = $tw->merge($c['root'], $attributesClass ?? '');

        $captionMonthChoices = [];
        for ($m = 1; $m <= 12; $m++) {
            $captionMonthChoices[] = [
                'value' => $m,
                'label' => Carbon::create(2020, $m, 1)->locale($calendarLocaleTag)->translatedFormat('M'),
            ];
        }

        $visibleYear = (int) Carbon::parse($visibleMonth)->format('Y');
        $effectiveMin = $bounds['min'];
        $effectiveMax = $bounds['max'];
        $hasMinY = $effectiveMin !== null && $effectiveMin !== '';
        $hasMaxY = $effectiveMax !== null && $effectiveMax !== '';

        if (! $hasMinY && ! $hasMaxY) {
            $captionYears = range(1900, 2100);
        } else {
            $pad = 50;
            $lo = $hasMinY ? (int) Carbon::parse($effectiveMin)->format('Y') : $visibleYear - $pad;
            $hi = $hasMaxY ? (int) Carbon::parse($effectiveMax)->format('Y') : $visibleYear + $pad;
            if (! $hasMinY && $visibleYear < $lo) {
                $lo = $visibleYear;
            }
            if (! $hasMaxY && $visibleYear > $hi) {
                $hi = $visibleYear;
            }
            if ($visibleYear < $lo) {
                $lo = $visibleYear;
            }
            if ($visibleYear > $hi) {
                $hi = $visibleYear;
            }
            $captionYears = range($lo, $hi);
        }

        return [
            'c' => $c,
            'modeKey' => $modeKey,
            'nMonths' => $nMonths,
            'captionLayoutKey' => $captionLayoutKey,
            'calConfig' => $calConfig,
            'rootClass' => $rootClass,
            'captionMonthChoices' => $captionMonthChoices,
            'captionYears' => $captionYears,
        ];
    }
}
