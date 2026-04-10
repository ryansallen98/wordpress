<?php

declare(strict_types=1);

namespace App\View\Components\Accordion;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Accordion extends ShadpineComponent
{
    public function __construct(
        public string $type = 'single',
        public string $dataSlot = 'accordion',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{root: string} $c */
        $c = config('components.accordion');
        $classes = $tw->merge($c['root'], $this->attributes->get('class'));

        return view('components.accordion.index', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
