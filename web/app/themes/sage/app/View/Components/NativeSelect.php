<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class NativeSelect extends Component
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

        $wrapperBase =
            'group/native-select relative w-fit has-[select:disabled]:opacity-50';
        $selectBase =
            'h-8 w-full min-w-0 appearance-none rounded-lg border border-input bg-transparent py-1 pr-8 pl-2.5 text-sm transition-colors outline-none select-none selection:bg-primary selection:text-primary-foreground placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50 disabled:pointer-events-none disabled:cursor-not-allowed aria-invalid:border-destructive aria-invalid:ring-3 aria-invalid:ring-destructive/20 data-[size=sm]:h-7 data-[size=sm]:rounded-[min(var(--radius-md),10px)] data-[size=sm]:py-0.5 dark:bg-input/30 dark:hover:bg-input/50 dark:aria-invalid:border-destructive/50 dark:aria-invalid:ring-destructive/40';
        $iconBase =
            'pointer-events-none absolute top-1/2 end-2.5 size-4 -translate-y-1/2 text-muted-foreground select-none rtl:**:[&>svg]:rotate-180';

        $wrapperClasses = $tw->merge($wrapperBase, $this->class);
        $selectClasses = $tw->merge($selectBase, $this->selectClass);
        $iconClasses = $tw->merge($iconBase, $this->iconClass);

        return view('components.native-select.index', array_merge($this->data(), [
            'wrapperClasses' => $wrapperClasses,
            'selectClasses' => $selectClasses,
            'iconClasses' => $iconClasses,
        ]));
    }
}
