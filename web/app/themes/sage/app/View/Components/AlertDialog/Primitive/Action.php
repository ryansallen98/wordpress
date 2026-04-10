<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use App\View\Components\AlertDialog\DialogCloseClick;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Action extends Component
{
    public function __construct(
        public string $dataSlot = 'alert-dialog-action',
    ) {}

    public function render(): ViewContract
    {
        $type = $this->attributes->get('type') ?? 'button';
        $mergedClick = DialogCloseClick::merge($this->attributes->get('x-on:click'));

        return view('components.alert-dialog.primitive.action', array_merge($this->data(), [
            'type' => $type,
            'mergedClick' => $mergedClick,
        ]));
    }
}
