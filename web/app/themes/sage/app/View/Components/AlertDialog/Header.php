<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Header extends ShadpineComponent
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
