<?php

declare(strict_types=1);

namespace App\View\Components\Alert;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Alert extends ShadpineComponent
{
    public function __construct(
        public string $dataSlot = 'alert',
        public string $role = 'alert',
        public string $variant = 'default',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{base: string, variants: array<string, string>} $config */
        $config = config('components.alert');

        $classes = $tw->merge(
            $config['base'],
            $config['variants'][$this->variant] ?? $config['variants']['default'],
            $this->attributes->get('class'),
        );

        return view('components.alert.index', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
