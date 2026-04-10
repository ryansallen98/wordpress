<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Trigger extends ShadpineComponent
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
