<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;

class Content extends ShadpineComponent
{
    public function __construct(
        public string $size = 'default',
        public string $dataSlot = 'alert-dialog-content',
    ) {}

    public function render(): ViewContract
    {
        return view('components.alert-dialog.primitive.content', $this->data());
    }
}
