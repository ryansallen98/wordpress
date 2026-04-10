<?php

declare(strict_types=1);

namespace App\View\Components\Badge;

use App\View\Components\Support\AllowedTag;
use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;
use TailwindMerge\TailwindMerge;

class Badge extends ShadpineComponent
{
    public function __construct(
        public string $as = 'span',
        public string $variant = 'default',
        public string $dataSlot = 'badge',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{base: string, variants: array<string, string>} $config */
        $config = config('components.badge');

        $tag = AllowedTag::resolve($this->as, ['a', 'button', 'span', 'div'], 'span');
        $classes = $tw->merge(
            $config['base'],
            $config['variants'][$this->variant] ?? $config['variants']['default'],
            $this->attributes->get('class'),
        );

        return view('components.badge.index', array_merge($this->data(), [
            'tag' => $tag,
            'classes' => $classes,
        ]));
    }
}
