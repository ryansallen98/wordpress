<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog\Primitive;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;

class Trigger extends Component
{
    public function __construct(
        public string $as = 'span',
        public string $dataSlot = 'alert-dialog-trigger',
    ) {}

    public function render(): ViewContract
    {
        $bladeComponent = str_starts_with($this->as, 'x-') ? substr($this->as, 2) : null;
        $nativeTags = ['button', 'a', 'span'];
        $tag = $bladeComponent === null && in_array($this->as, $nativeTags, true) ? $this->as : 'span';

        return view('components.alert-dialog.primitive.trigger', array_merge($this->data(), [
            'bladeComponent' => $bladeComponent,
            'tag' => $tag,
        ]));
    }
}
