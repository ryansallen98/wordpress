<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class AlertDialog extends ShadpineComponent
{
    public function __construct(
        public string $dataSlot = 'alert-dialog',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{root: string} $c */
        $c = config('components.alert_dialog');
        $classes = $tw->merge($c['root'], $this->attributes->get('class'));
        $defaultOpen = $this->attributes->boolean('default-open') || $this->attributes->boolean('defaultOpen');

        return view('components.alert-dialog.index', array_merge($this->data(), [
            'classes' => $classes,
            'defaultOpen' => $defaultOpen,
        ]));
    }
}
