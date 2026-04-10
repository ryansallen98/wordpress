<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class ButtonGroup extends Component
{
    public function __construct(
        public string $orientation = 'horizontal',
        public string $dataSlot = 'button-group',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{group: array{base: string, orientation: array<string, string>}} $c */
        $c = config('classes.button_group');
        $orientationKey = in_array($this->orientation, ['horizontal', 'vertical'], true)
            ? $this->orientation
            : 'horizontal';

        $classes = $tw->merge(
            $c['group']['base'],
            $c['group']['orientation'][$orientationKey],
            $this->attributes->get('class'),
        );

        return view('components.button-group.index', array_merge($this->data(), [
            'classes' => $classes,
            'orientationKey' => $orientationKey,
        ]));
    }
}
