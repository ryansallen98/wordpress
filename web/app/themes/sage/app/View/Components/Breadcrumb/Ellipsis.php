<?php

declare(strict_types=1);

namespace App\View\Components\Breadcrumb;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Ellipsis extends Component
{
    public function __construct(
        public string $dataSlot = 'breadcrumb-ellipsis',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $classes = $tw->merge(
            'flex size-9 items-center justify-center [&>svg]:size-4',
            $this->attributes->get('class'),
        );

        return view('components.breadcrumb.ellipsis', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
