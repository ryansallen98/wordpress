<?php

declare(strict_types=1);

namespace App\View\Components\Accordion;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Item extends Component
{
    public function __construct(
        public bool $open = false,
        public string $dataSlot = 'accordion-item',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $base = 'not-last:border-b';
        $classes = $tw->merge($base, $this->attributes->get('class'));

        return view('components.accordion.item', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
