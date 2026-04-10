<?php

declare(strict_types=1);

namespace App\View\Components\Button;

use App\View\Components\Support\AllowedTag;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Icon extends Component
{
    public function __construct(
        public string $as = 'button',
        public string $variant = 'default',
        public string $size = 'default',
        public string $dataSlot = 'button',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        $tag = AllowedTag::resolve($this->as, ['a', 'button', 'span', 'div'], 'button');
        $classes = ButtonClasses::merge($tw, $this->variant, $this->size, $this->attributes->get('class'), true);

        return view('components.button.icon', array_merge($this->data(), [
            'tag' => $tag,
            'classes' => $classes,
        ]));
    }
}
