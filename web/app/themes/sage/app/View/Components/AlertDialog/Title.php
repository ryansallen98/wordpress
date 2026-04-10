<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Title extends ShadpineComponent
{
    public function __construct(
        public string $as = 'h2',
        public string $dataSlot = 'alert-dialog-title',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        /** @var array{title: string} $c */
        $c = config('components.alert_dialog');
        $classes = $tw->merge(
            $c['title'],
            $this->attributes->get('class'),
        );

        return view('components.alert-dialog.title', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
