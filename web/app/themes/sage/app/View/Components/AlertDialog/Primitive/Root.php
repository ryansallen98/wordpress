<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;

class Root extends ShadpineComponent
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
