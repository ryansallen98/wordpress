<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class AlertDialog extends Component
{
    public function __construct(
        public string $dataSlot = 'alert-dialog',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        $classes = $tw->merge('contents', $this->attributes->get('class'));
        $defaultOpen = $this->attributes->boolean('default-open') || $this->attributes->boolean('defaultOpen');

        return view('components.alert-dialog.index', array_merge($this->data(), [
            'classes' => $classes,
            'defaultOpen' => $defaultOpen,
        ]));
    }
}
