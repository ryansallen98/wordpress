<?php

declare(strict_types=1);

namespace App\View\Components\Alert;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Action extends Component
{
    public function __construct(
        public string $dataSlot = 'alert-action',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        $classes = $tw->merge(
            'absolute top-2 right-2',
            $this->attributes->get('class'),
        );

        return view('components.alert.action', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
