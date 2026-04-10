<?php

declare(strict_types=1);

namespace App\View\Components\NativeSelect;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Group extends ShadpineComponent
{
    public function __construct(
        public string $label = '',
        public bool $disabled = false,
        public string $dataSlot = 'native-select-optgroup',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{optgroup: string} $c */
        $c = config('components.native_select');
        $groupClasses = $tw->merge($c['optgroup'], $this->attributes->get('class'));

        return view('components.native-select.group', array_merge($this->data(), [
            'groupClasses' => $groupClasses,
        ]));
    }
}
