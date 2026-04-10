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

        /** @var array{list: string} $c */
        $c = config('components.breadcrumb');
        $listClasses = $tw->merge(
            $c['list'],
            $this->attributes->get('class'),
        );

        return view('components.breadcrumb.index', array_merge($this->data(), [
            'label' => $label,
            'listClasses' => $listClasses,
        ]));
    }
}
