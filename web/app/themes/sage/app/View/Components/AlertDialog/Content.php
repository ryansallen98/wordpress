<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Content extends Component
{
    public function __construct(
        public string $size = 'default',
        public string $dataSlot = 'alert-dialog-content',
        public string $duration = 'duration-100',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        $overlayClasses = $tw->merge(
            "fixed inset-0 z-50 bg-black/10 {$this->duration} supports-backdrop-filter:backdrop-blur-xs data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=closed]:animate-out data-[state=closed]:fade-out-0"
        );
        $panelClasses = $tw->merge(
            "group/alert-dialog-content fixed top-1/2 left-1/2 z-50 grid w-full -translate-x-1/2 -translate-y-1/2 gap-4 rounded-xl bg-popover p-4 text-popover-foreground ring-1 ring-foreground/10 {$this->duration} outline-none data-[size=default]:max-w-xs data-[size=sm]:max-w-xs data-[size=default]:sm:max-w-sm data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95 data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95",
            $this->attributes->get('class'),
        );

        return view('components.alert-dialog.content', array_merge($this->data(), [
            'overlayClasses' => $overlayClasses,
            'panelClasses' => $panelClasses,
        ]));
    }
}
