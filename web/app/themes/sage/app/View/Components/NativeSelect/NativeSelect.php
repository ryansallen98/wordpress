<?php

declare(strict_types=1);

namespace App\View\Components\NativeSelect;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class NativeSelect extends ShadpineComponent
{
    public function __construct(
        public string $class = '',
        public string $selectClass = '',
        public string $iconClass = '',
        public string $size = 'default',
        public string $wrapperDataSlot = 'native-select-wrapper',
        public string $selectDataSlot = 'native-select',
        public string $iconDataSlot = 'native-select-icon',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{wrapper: string, select: string, icon: string} $c */
        $c = config('components.native_select');

        $wrapperClasses = $tw->merge($c['wrapper'], $this->class);
        $selectClasses = $tw->merge($c['select'], $this->selectClass);
        $iconClasses = $tw->merge($c['icon'], $this->iconClass);

        return view('components.native-select.index', array_merge($this->data(), [
            'wrapperClasses' => $wrapperClasses,
            'selectClasses' => $selectClasses,
            'iconClasses' => $iconClasses,
        ]));
    }
}
