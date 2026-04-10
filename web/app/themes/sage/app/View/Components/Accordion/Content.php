<?php

declare(strict_types=1);

namespace App\View\Components\Accordion;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Content extends ShadpineComponent
{
    public function __construct(
        public string $dataSlot = 'accordion-content',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{content: string} $c */
        $c = config('components.accordion');
        $classes = $tw->merge($c['content'], $this->attributes->get('class'));

        return view('components.accordion.content', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
