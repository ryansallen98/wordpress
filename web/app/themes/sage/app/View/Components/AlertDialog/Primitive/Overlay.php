<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;

class Overlay extends ShadpineComponent
{
    public function __construct(
        public string $dataSlot = 'alert-dialog-overlay',
    ) {}

    public function render(): ViewContract
    {
        return view('components.alert-dialog.primitive.overlay', $this->data());
    }
}
