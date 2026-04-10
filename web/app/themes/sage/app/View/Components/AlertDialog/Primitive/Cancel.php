<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use App\View\Components\AlertDialog\DialogCloseClick;
use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;

class Cancel extends ShadpineComponent
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
