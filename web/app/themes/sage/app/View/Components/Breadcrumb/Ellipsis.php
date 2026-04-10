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
        /** @var array{ellipsis: string} $c */
        $c = config('components.breadcrumb');
        $classes = $tw->merge(
            $c['ellipsis'],
            $this->attributes->get('class'),
        );

        return view('components.breadcrumb.ellipsis', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
