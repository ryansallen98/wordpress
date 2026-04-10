<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use App\View\Components\Button\ButtonClasses;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Cancel extends Component
{
    public function __construct(
        public bool $autofocus = true,
        public string $variant = 'outline',
        public string $size = 'default',
        public string $dataSlot = 'alert-dialog-cancel',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $classes = ButtonClasses::merge($tw, $this->variant, $this->size, $this->attributes->get('class'), false);

        return view('components.alert-dialog.cancel', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
