<?php

declare(strict_types=1);

namespace App\View\Components\Accordion\Primitive;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Root extends Component
{
    public function __construct(
        public string $type = 'single',
        public string $dataSlot = 'accordion',
    ) {}

    public function render(): ViewContract
    {
        return view('components.accordion.primitive.root', $this->data());
    }
}
