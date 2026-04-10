<?php

declare(strict_types=1);

namespace App\View\Components\Accordion;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Item extends ShadpineComponent
{
    public function __construct(
        public bool $open = false,
        public string $dataSlot = 'accordion-item',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{item: string} $c */
        $c = config('components.accordion');
        $classes = $tw->merge($c['item'], $this->attributes->get('class'));

        return view('components.accordion.item', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
