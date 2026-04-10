<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Description extends ShadpineComponent
{
    public function __construct(
        public string $as = 'p',
        public string $dataSlot = 'alert-dialog-description',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        /** @var array{description: string} $c */
        $c = config('components.alert_dialog');
        $classes = $tw->merge(
            $c['description'],
            $this->attributes->get('class'),
        );

        return view('components.alert-dialog.description', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
