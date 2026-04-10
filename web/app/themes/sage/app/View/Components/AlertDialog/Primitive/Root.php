<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Root extends Component
{
    public function __construct(
        public bool $defaultOpen = false,
        public string $dataSlot = 'alert-dialog',
    ) {}

    public function render(): ViewContract
    {
        return view('components.alert-dialog.primitive.root', $this->data());
    }
}
