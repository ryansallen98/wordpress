<?php

declare(strict_types=1);

namespace App\View\Components\Breadcrumb;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Link extends Component
{
    public function __construct(
        public string $href = '#',
        public string $dataSlot = 'breadcrumb-link',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        /** @var array{link: string} $c */
        $c = config('components.breadcrumb');
        $classes = $tw->merge(
            $c['link'],
            $this->attributes->get('class'),
        );

        return view('components.breadcrumb.link', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
