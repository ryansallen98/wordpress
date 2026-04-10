<?php

declare(strict_types=1);

namespace App\View\Components\Button;

use TailwindMerge\TailwindMerge;

final class ButtonClasses
{
    public static function merge(
        TailwindMerge $tw,
        string $variant,
        string $size,
        ?string $attributesClass,
        bool $iconSizes = false,
    ): string {
        /** @var array{base: string, variants: array<string, string>, sizes: array<string, string>, icon_sizes: array<string, string>} $config */
        $config = config('components.button');

        $sizeKey = $iconSizes ? 'icon_sizes' : 'sizes';

        return $tw->merge(
            $config['base'],
            $config['variants'][$variant] ?? $config['variants']['default'],
            $config[$sizeKey][$size] ?? $config[$sizeKey]['default'],
            $attributesClass ?? '',
        );
    }
}
