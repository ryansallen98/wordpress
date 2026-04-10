<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;

class Portal extends ShadpineComponent
{
    public function __construct(
        public string $dataSlot = 'alert-dialog-portal',
        /** Empty uses `components.alert_dialog.default_duration_segment`. */
        public string $enterDuration = '',
        public string $leaveDuration = '',
    ) {}

    public function render(): ViewContract
    {
        /** @var array{default_duration_segment: string} $c */
        $c = config('components.alert_dialog');
        $def = $c['default_duration_segment'];
        $enter = $this->enterDuration !== '' ? $this->enterDuration : $def;
        $leave = $this->leaveDuration !== '' ? $this->leaveDuration : $def;

        return view('components.alert-dialog.primitive.portal', array_merge($this->data(), [
            'enterDuration' => $enter,
            'leaveDuration' => $leave,
        ]));
    }
}
