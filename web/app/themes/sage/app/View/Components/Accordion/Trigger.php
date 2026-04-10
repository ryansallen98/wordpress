<?php

declare(strict_types=1);

namespace App\View\Components\Accordion;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Trigger extends ShadpineComponent
{
    public function __construct(
        public string $dataSlot = 'accordion-trigger',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{trigger: string} $c */
        $c = config('components.accordion');
        $classes = $tw->merge($c['trigger'], $this->attributes->get('class'));

        return view('components.accordion.trigger', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
