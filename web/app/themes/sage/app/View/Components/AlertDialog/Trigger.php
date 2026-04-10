<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Trigger extends Component
{
    public function __construct(
        public string $as = 'span',
        public string $dataSlot = 'alert-dialog-trigger',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $classes = $tw->merge($this->attributes->get('class'));

        return view('components.alert-dialog.trigger', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
