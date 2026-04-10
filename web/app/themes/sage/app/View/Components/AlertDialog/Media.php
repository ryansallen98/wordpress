<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Media extends Component
{
    public function __construct(
        public string $dataSlot = 'alert-dialog-media',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $classes = $tw->merge(
            "mb-2 inline-flex size-10 items-center justify-center rounded-md bg-muted sm:group-data-[size=default]/alert-dialog-content:row-span-2 *:[svg:not([class*='size-'])]:size-6",
            $this->attributes->get('class'),
        );

        return view('components.alert-dialog.media', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
