<?php

declare(strict_types=1);

namespace App\View\Components\NativeSelect;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Group extends Component
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
        $optgroupBase = 'bg-[Canvas] text-[CanvasText]';
        $groupClasses = $tw->merge($optgroupBase, $this->attributes->get('class'));

        return view('components.native-select.group', array_merge($this->data(), [
            'groupClasses' => $groupClasses,
        ]));
    }
}
