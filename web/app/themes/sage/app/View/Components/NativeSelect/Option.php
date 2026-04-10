<?php

declare(strict_types=1);

namespace App\View\Components\NativeSelect;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Option extends Component
{
    public function __construct(
        public bool $selected = false,
        public string $dataSlot = 'native-select-option',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $optionBase = 'bg-[Canvas] text-[CanvasText]';
        $optionClasses = $tw->merge($optionBase, $this->attributes->get('class'));

        return view('components.native-select.option', array_merge($this->data(), [
            'optionClasses' => $optionClasses,
        ]));
    }
}
