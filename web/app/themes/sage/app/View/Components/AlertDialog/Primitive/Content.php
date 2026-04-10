<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Content extends Component
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
