<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use App\View\Components\AlertDialog\DialogCloseClick;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Cancel extends Component
{
    public function __construct(
        public bool $autofocus = true,
        public string $dataSlot = 'alert-dialog-cancel',
    ) {}

    public function render(): ViewContract
    {
        $passthrough = $this->autofocus
            ? $this->attributes->merge(['autofocus' => true])
            : $this->attributes;

        $mergedClick = DialogCloseClick::merge($passthrough->get('x-on:click'));

        return view('components.alert-dialog.primitive.cancel', array_merge($this->data(), [
            'passthrough' => $passthrough,
            'mergedClick' => $mergedClick,
        ]));
    }
}
