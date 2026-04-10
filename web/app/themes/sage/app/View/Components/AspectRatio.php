<?php

declare(strict_types=1);

namespace App\View\Components;

use App\View\Components\AspectRatio\Dimensions;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class AspectRatio extends Component
{
    public function __construct(
        public string $ratio = '16/9',
        public string $dataSlot = 'aspect-ratio',
    ) {}

    public function render(): ViewContract
    {
        [$rw, $rh] = Dimensions::parse($this->ratio);

        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $classes = $tw->merge(
            'relative w-full overflow-hidden',
            $this->attributes->get('class'),
        );

        return view('components.aspect-ratio.index', array_merge($this->data(), [
            'rw' => $rw,
            'rh' => $rh,
            'classes' => $classes,
        ]));
    }
}
