<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Content extends ShadpineComponent
{
    public function __construct(
        public string $size = 'default',
        public string $dataSlot = 'alert-dialog-content',
        /** Tailwind duration segment; empty uses `components.alert_dialog.default_duration_segment`. */
        public string $duration = '',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{default_duration_segment: string, overlay: string, panel: string} $c */
        $c = config('components.alert_dialog');
        $segment = $this->duration !== '' ? $this->duration : $c['default_duration_segment'];

        $overlayClasses = $tw->merge(
            str_replace('{duration}', $segment, $c['overlay'])
        );
        $panelClasses = $tw->merge(
            str_replace('{duration}', $segment, $c['panel']),
            $this->attributes->get('class'),
        );

        return view('components.alert-dialog.content', array_merge($this->data(), [
            'overlayClasses' => $overlayClasses,
            'panelClasses' => $panelClasses,
        ]));
    }
}
