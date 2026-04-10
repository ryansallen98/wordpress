<?php

declare(strict_types=1);

namespace App\View\Components\Support;

use Illuminate\View\Component as IlluminateComponent;

/**
 * Workaround: Blade compiles class components as
 * {@code startComponent($component->resolveView(), $component->data())}, so PHP evaluates
 * {@code resolveView()} (which calls {@see render()}) before {@see data()} initializes
 * {@code $this->attributes}. Calling {@see data()} first matches {@see \Illuminate\View\Compilers\BladeCompiler::renderComponent()}.
 */
abstract class ShadpineComponent extends IlluminateComponent
{
    public function resolveView()
    {
        $this->data();

        return parent::resolveView();
    }
}
