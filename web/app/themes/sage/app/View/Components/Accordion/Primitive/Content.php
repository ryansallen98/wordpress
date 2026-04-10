<?php

declare(strict_types=1);

namespace App\View\Components\Accordion\Primitive;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Content extends Component
{
    public function __construct(
        public string $dataSlot = 'accordion-content',
    ) {}

    public function render(): ViewContract
    {
        return view('components.accordion.primitive.content', $this->data());
    }
}
