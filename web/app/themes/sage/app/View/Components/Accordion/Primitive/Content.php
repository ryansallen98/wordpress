<?php

declare(strict_types=1);

namespace App\View\Components\Accordion\Primitive;

use App\View\Components\Support\ShadpineComponent;
use Illuminate\Contracts\View\View as ViewContract;

class Content extends ShadpineComponent
{
    public function __construct(
        public string $dataSlot = 'accordion-content',
    ) {}

    public function render(): ViewContract
    {
        return view('components.accordion.primitive.content', $this->data());
    }
}
