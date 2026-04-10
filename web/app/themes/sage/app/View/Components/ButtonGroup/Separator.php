<?php

declare(strict_types=1);

namespace App\View\Components\ButtonGroup;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Separator extends ShadpineComponent
{
    public function __construct(
        public string $orientation = 'vertical',
        public string $dataSlot = 'button-group-separator',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{separator: array{radix: string, group: string}} $c */
        $c = config('components.button_group');
        $orientationKey = in_array($this->orientation, ['horizontal', 'vertical'], true)
            ? $this->orientation
            : 'vertical';

        $classes = $tw->merge(
            $c['separator']['radix'],
            $c['separator']['group'],
            $this->attributes->get('class'),
        );

        return view('components.button-group.separator', array_merge($this->data(), [
            'classes' => $classes,
            'orientationKey' => $orientationKey,
        ]));
    }
}
