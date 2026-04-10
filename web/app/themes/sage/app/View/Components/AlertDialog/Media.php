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
        /** @var array{media: string} $c */
        $c = config('components.alert_dialog');
        $classes = $tw->merge(
            $c['media'],
            $this->attributes->get('class'),
        );

        return view('components.alert-dialog.media', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
