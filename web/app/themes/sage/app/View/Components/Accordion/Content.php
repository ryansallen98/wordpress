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

        /** @var array{content: string} $c */
        $c = config('components.accordion');
        $classes = $tw->merge($c['content'], $this->attributes->get('class'));

        return view('components.accordion.content', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
