<?php

declare(strict_types=1);

namespace App\View\Components\Alert;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Description extends Component
{
    public function __construct(
        public string $as = 'div',
        public string $dataSlot = 'alert-description',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        $classes = $tw->merge(
            'text-sm text-balance text-muted-foreground md:text-pretty [&_a]:underline [&_a]:underline-offset-3 [&_a]:hover:text-foreground [&_p:not(:last-child)]:mb-4',
            $this->attributes->get('class'),
        );

        return view('components.alert.description', array_merge($this->data(), [
            'tag' => $this->as,
            'classes' => $classes,
        ]));
    }
}
