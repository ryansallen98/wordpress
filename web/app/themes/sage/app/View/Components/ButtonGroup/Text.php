<?php

declare(strict_types=1);

namespace App\View\Components\ButtonGroup;

use App\View\Components\Support\AllowedTag;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Text extends Component
{
    public function __construct(
        public string $as = 'div',
        public string $dataSlot = 'button-group-text',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');

        /** @var array{text: array{base: string}} $c */
        $c = config('components.button_group');

        $tag = AllowedTag::resolve($this->as, ['div', 'span', 'label'], 'div');
        $classes = $tw->merge($c['text']['base'], $this->attributes->get('class'));

        return view('components.button-group.text', array_merge($this->data(), [
            'tag' => $tag,
            'classes' => $classes,
        ]));
    }
}
