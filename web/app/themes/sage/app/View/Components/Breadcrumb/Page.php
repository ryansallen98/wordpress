<?php

declare(strict_types=1);

namespace App\View\Components\Breadcrumb;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Page extends Component
{
    public function __construct(
        public string $dataSlot = 'breadcrumb-page',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        /** @var array{page: string} $c */
        $c = config('components.breadcrumb');
        $classes = $tw->merge($c['page'], $this->attributes->get('class'));

        return view('components.breadcrumb.page', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
