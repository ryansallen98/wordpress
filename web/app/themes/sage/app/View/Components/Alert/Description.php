<?php

declare(strict_types=1);

namespace App\View\Components\Alert;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Description extends ShadpineComponent
{
    public function __construct(
        public string $as = 'div',
        public string $dataSlot = 'alert-description',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{description: string} $config */
        $config = config('components.alert');
        $classes = $tw->merge(
            $config['description'],
            $this->attributes->get('class'),
        );

        return view('components.alert.description', array_merge($this->data(), [
            'tag' => $this->as,
            'classes' => $classes,
        ]));
    }
}
