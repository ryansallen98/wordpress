<?php

declare(strict_types=1);

namespace App\View\Components\Accordion\Primitive;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;

class Root extends ShadpineComponent
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
