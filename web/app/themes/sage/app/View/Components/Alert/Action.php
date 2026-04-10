<?php

declare(strict_types=1);

namespace App\View\Components\Alert;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Action extends Component
{
    public function __construct(
        public string $dataSlot = 'alert-action',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{action: string} $config */
        $config = config('components.alert');
        $classes = $tw->merge(
            $config['action'],
            $this->attributes->get('class'),
        );

        return view('components.alert.action', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
