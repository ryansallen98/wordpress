@props([
    'autofocus' => true,
    'dataSlot' => 'alert-dialog-cancel',
])
@php
    $passthrough = $autofocus
        ? $attributes->merge(['autofocus' => true])
        : $attributes;
    $userClick = $passthrough->get('x-on:click');
    if ($userClick === null || $userClick === '') {
        $mergedClick = 'closeDialog()';
    } else {
        $trimmed = mb_rtrim((string) $userClick, '; ');
        $mergedClick = str_contains($trimmed, 'closeDialog')
            ? $trimmed
            : $trimmed . '; closeDialog()';
    }
@endphp

<button
    type="button"
    data-slot="{{ $dataSlot }}"
    x-on:click="{!! $mergedClick !!}"
    {{ $passthrough->except(['x-on:click', 'dataSlot']) }}
>
    {{ $slot }}
</button>
