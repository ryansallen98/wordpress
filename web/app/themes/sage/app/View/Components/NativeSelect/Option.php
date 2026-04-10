<?php

declare(strict_types=1);

namespace App\View\Components\NativeSelect;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Option extends ShadpineComponent
{
    public function __construct(
        public bool $selected = false,
        public string $dataSlot = 'native-select-option',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{option: string} $c */
        $c = config('components.native_select');
        $optionClasses = $tw->merge($c['option'], $this->attributes->get('class'));

        return view('components.native-select.option', array_merge($this->data(), [
            'optionClasses' => $optionClasses,
        ]));
    }
}
