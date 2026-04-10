@props([
    'dataSlot' => 'alert-dialog-action',
])
@php
    $type = $attributes->get('type') ?? 'button';
    $userClick = $attributes->get('x-on:click');
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
    type="{{ $type }}"
    data-slot="{{ $dataSlot }}"
    x-on:click="{!! $mergedClick !!}"
    {{ $attributes->except(['x-on:click', 'dataSlot', 'type']) }}
>
    {{ $slot }}
</button>
