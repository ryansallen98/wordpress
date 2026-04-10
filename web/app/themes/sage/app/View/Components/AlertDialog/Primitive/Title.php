<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Title extends Component
{
    public function __construct(
        public string $as = 'h2',
        public string $dataSlot = 'alert-dialog-title',
    ) {}

    public function render(): ViewContract
    {
        return view('components.alert-dialog.primitive.title', array_merge($this->data(), [
            'tag' => $this->as,
        ]));
    }
}
