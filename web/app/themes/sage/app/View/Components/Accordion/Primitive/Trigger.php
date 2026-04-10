<?php

declare(strict_types=1);

namespace App\View\Components\Accordion\Primitive;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Trigger extends Component
{
    public function __construct(
        public int $level = 3,
        public string $dataSlot = 'accordion-trigger',
    ) {}

    public function render(): ViewContract
    {
        return view('components.accordion.primitive.trigger', $this->data());
    }
}
