<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Overlay extends Component
{
    public function __construct(
        public string $dataSlot = 'alert-dialog-overlay',
    ) {}

    public function render(): ViewContract
    {
        return view('components.alert-dialog.primitive.overlay', $this->data());
    }
}
