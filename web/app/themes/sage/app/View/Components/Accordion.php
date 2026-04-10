<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Accordion extends Component
{
    public function __construct(
        public string $type = 'single',
        public string $dataSlot = 'accordion',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $base = 'flex w-full flex-col';
        $classes = $tw->merge($base, $this->attributes->get('class'));

        return view('components.accordion.index', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
