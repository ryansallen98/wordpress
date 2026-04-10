<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Title extends Component
{
    public function __construct(
        public string $as = 'h2',
        public string $dataSlot = 'alert-dialog-title',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $classes = $tw->merge(
            'cn-font-heading text-base font-medium sm:group-data-[size=default]/alert-dialog-content:group-has-data-[slot=alert-dialog-media]/alert-dialog-content:col-start-2',
            $this->attributes->get('class'),
        );

        return view('components.alert-dialog.title', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
