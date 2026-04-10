<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Header extends Component
{
    public function __construct(
        public string $dataSlot = 'alert-dialog-header',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        /** @var array{header: string} $c */
        $c = config('components.alert_dialog');
        $classes = $tw->merge(
            $c['header'],
            $this->attributes->get('class'),
        );

        return view('components.alert-dialog.header', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
