<?php

declare(strict_types=1);

namespace App\View\Components\Accordion\Primitive;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Item extends Component
{
    public function __construct(
        public bool $open = false,
        public string $dataSlot = 'accordion-item',
    ) {}

    public function render(): ViewContract
    {
        return view('components.accordion.primitive.item', $this->data());
    }
}
