<?php

declare(strict_types=1);

namespace App\View\Components\AspectRatio;

final class Dimensions
{
    /**
     * @return array{0: int, 1: int}
     */
    public static function parse(string $ratio): array
    {
        $r = trim($ratio);
        $pair = match (true) {
            in_array($r, ['1', '1/1', 'square'], true) => [1, 1],
            in_array($r, ['16/9', 'video'], true) => [16, 9],
            (bool) preg_match('/^\s*(\d+)\s*\/\s*(\d+)\s*$/', $r, $m) => [(int) $m[1], (int) $m[2]],
            default => [16, 9],
        };

        if ($pair[0] < 1 || $pair[1] < 1) {
            return [16, 9];
        }

        return $pair;
    }
}
