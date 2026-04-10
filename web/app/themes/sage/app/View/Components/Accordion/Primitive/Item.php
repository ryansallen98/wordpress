<?php

declare(strict_types=1);

namespace App\View\Components\Accordion\Primitive;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;

class Item extends ShadpineComponent
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
