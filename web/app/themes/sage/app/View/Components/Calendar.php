<?php

declare(strict_types=1);

namespace App\View\Components;

use App\View\Components\Calendar\ViewState;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

/**
 * Calendar grid (Blade shell + Alpine). View data is built in {@see ViewState}.
 */
class Calendar extends Component
{
    /**
     * @param  array<int|string, mixed>|mixed  $disabled
     * @param  array<string, mixed>|mixed  $modifiers
     * @param  array<string, mixed>|mixed  $modifiersClassNames
     */
    public function __construct(
        public string $mode = 'single',
        public mixed $weekStartsOn = 0,
        public mixed $showOutsideDays = true,
        public ?string $month = null,
        public ?string $selected = null,
        public ?string $min = null,
        public ?string $max = null,
        public ?string $locale = null,
        public mixed $numberOfMonths = 1,
        public string $captionLayout = 'dropdown',
        public ?string $timeZone = null,
        public mixed $disabled = [],
        public mixed $modifiers = [],
        public mixed $modifiersClassNames = [],
        public string $dataSlot = 'calendar',
        public mixed $disablePast = false,
        public mixed $disableFuture = false,
    ) {}

    public function render(): ViewContract
    {
        $disabled = is_array($this->disabled) ? $this->disabled : [];
        $modifiers = is_array($this->modifiers) ? $this->modifiers : [];
        $modifiersClassNames = is_array($this->modifiersClassNames) ? $this->modifiersClassNames : [];

        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array<string, string> $calendarClasses */
        $calendarClasses = config('classes.calendar');

        $defaultLocale = str_replace('_', '-', app()->getLocale());

        $state = ViewState::make(
            $this->mode,
            $this->weekStartsOn,
            $this->showOutsideDays,
            $this->month,
            $this->selected,
            $this->min,
            $this->max,
            $this->locale,
            $this->numberOfMonths,
            $this->captionLayout,
            $this->timeZone,
            $disabled,
            $modifiers,
            $modifiersClassNames,
            $this->disablePast,
            $this->disableFuture,
            $this->attributes->get('class'),
            $calendarClasses,
            $defaultLocale,
            $tw,
        );

        return view('components.calendar.index', array_merge($state, [
            'dataSlot' => $this->dataSlot,
            'tw' => $tw,
        ]));
    }
}
