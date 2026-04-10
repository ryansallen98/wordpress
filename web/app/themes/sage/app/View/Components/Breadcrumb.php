<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Breadcrumb extends Component
{
    public function __construct(
        public ?string $ariaLabel = null,
        public string $navDataSlot = 'breadcrumbs',
        public string $listDataSlot = 'breadcrumb-list',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        $label = $this->ariaLabel ?? __('Breadcrumbs', 'sage');
        $listClasses = $tw->merge(
            'm-0 flex list-none flex-wrap items-center gap-1.5 break-words text-sm text-muted-foreground',
            $this->attributes->get('class'),
        );

        return view('components.breadcrumb.index', array_merge($this->data(), [
            'label' => $label,
            'listClasses' => $listClasses,
        ]));
    }
}
