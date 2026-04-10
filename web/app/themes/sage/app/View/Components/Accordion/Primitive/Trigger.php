<?php

declare(strict_types=1);

namespace App\View\Components\Accordion\Primitive;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;

class Trigger extends ShadpineComponent
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
