<?php

declare(strict_types=1);

namespace App\View\Components\Accordion;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Content extends Component
{
    public function __construct(
        public string $dataSlot = 'accordion-content',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $base = 'grid overflow-hidden text-sm transition-[grid-template-rows] duration-200 ease-out motion-reduce:duration-0 data-[state=closed]:grid-rows-[0fr] data-[state=open]:grid-rows-[1fr]';
        $classes = $tw->merge($base, $this->attributes->get('class'));

        return view('components.accordion.content', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
