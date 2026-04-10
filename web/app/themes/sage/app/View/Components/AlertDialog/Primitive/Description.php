<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;

class Description extends ShadpineComponent
{
    public function __construct(
        public string $as = 'p',
        public string $dataSlot = 'alert-dialog-description',
    ) {}

    public function render(): ViewContract
    {
        return view('components.alert-dialog.primitive.description', array_merge($this->data(), [
            'tag' => $this->as,
        ]));
    }
}
