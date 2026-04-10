<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Portal extends Component
{
    public function __construct(
        public string $dataSlot = 'alert-dialog-portal',
        public string $enterDuration = 'duration-100',
        public string $leaveDuration = 'duration-100',
    ) {}

    public function render(): ViewContract
    {
        return view('components.alert-dialog.primitive.portal', $this->data());
    }
}
