<?php

declare(strict_types=1);

namespace App\View\Components\Accordion;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Trigger extends Component
{
    public function __construct(
        public string $dataSlot = 'accordion-trigger',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $base = 'group/accordion-trigger relative flex flex-1 items-start justify-between rounded-lg border border-transparent py-2.5 text-left text-sm font-medium transition-all outline-none hover:underline focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50 focus-visible:after:border-ring disabled:pointer-events-none disabled:opacity-50 **:data-[slot=accordion-trigger-icon]:ml-auto **:data-[slot=accordion-trigger-icon]:size-4 **:data-[slot=accordion-trigger-icon]:text-muted-foreground';
        $classes = $tw->merge($base, $this->attributes->get('class'));

        return view('components.accordion.trigger', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
