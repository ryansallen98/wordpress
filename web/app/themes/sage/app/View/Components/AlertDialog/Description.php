<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use TailwindMerge\TailwindMerge;

class Description extends Component
{
    public function __construct(
        public string $as = 'p',
        public string $dataSlot = 'alert-dialog-description',
    ) {}

    public function render(): ViewContract
    {
        /** @var TailwindMerge $tw */
        $tw = app('tw');
        $classes = $tw->merge(
            'text-sm text-balance text-muted-foreground md:text-pretty *:[a]:underline *:[a]:underline-offset-3 *:[a]:hover:text-foreground',
            $this->attributes->get('class'),
        );

        return view('components.alert-dialog.description', array_merge($this->data(), [
            'classes' => $classes,
        ]));
    }
}
