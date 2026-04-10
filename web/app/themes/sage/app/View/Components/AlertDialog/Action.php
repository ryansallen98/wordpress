<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use App\View\Components\Button\ButtonClasses;
use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Action extends ShadpineComponent
{
    public function __construct(
        public string $variant = 'default',
        public string $size = 'default',
        public string $dataSlot = 'alert-dialog-action',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $classes = ButtonClasses::merge($tw, $this->variant, $this->size, $this->attributes->get('class'), false);

        return view('components.alert-dialog.action', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
