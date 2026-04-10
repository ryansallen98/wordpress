<?php

declare(strict_types=1);

namespace App\View\Components\AlertDialog;

final class DialogCloseClick
{
    public static function merge(?string $userClick): string
    {
        if ($userClick === null || $userClick === '') {
            return 'closeDialog()';
        }

        $trimmed = mb_rtrim((string) $userClick, '; ');

        return str_contains($trimmed, 'closeDialog')
            ? $trimmed
            : $trimmed.'; closeDialog()';
    }
}
