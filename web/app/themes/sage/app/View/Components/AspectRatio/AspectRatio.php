<?php

declare(strict_types=1);

namespace App\View\Components\AspectRatio;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class AspectRatio extends ShadpineComponent
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
        /** @var array{root: string} $c */
        $c = config('components.aspect_ratio');
        $classes = $tw->merge(
            $c['root'],
            $this->attributes->get('class'),
        );

        return view('components.aspect-ratio.index', array_merge($this->data(), [
            'rw' => $rw,
            'rh' => $rh,
            'classes' => $classes,
        ]));
    }
}
