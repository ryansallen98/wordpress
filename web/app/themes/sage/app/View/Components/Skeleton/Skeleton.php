<?php

declare(strict_types=1);

namespace App\View\Components\Skeleton;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Skeleton extends ShadpineComponent
{
    public function __construct(
        public string $dataSlot = 'skeleton',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{root: string} $c */
        $c = config('components.skeleton');
        $classes = $tw->merge(
            $c['root'],
            $this->attributes->get('class'),
        );

        return view('components.skeleton.index', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
