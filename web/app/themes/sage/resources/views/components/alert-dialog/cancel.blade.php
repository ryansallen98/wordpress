@props([
    'autofocus' => true,
    'variant' => 'outline',
    'size' => 'default',
    'dataSlot' => 'alert-dialog-cancel',
])
@php
    $b = config('classes.button');
    $classes = $tw->merge(
        $b['base'],
        $b['variants'][$variant] ?? $b['variants']['default'],
        $b['sizes'][$size] ?? $b['sizes']['default'],
        $attributes->get('class')
    );
@endphp

<x-alert-dialog.primitive.cancel
    :autofocus="$autofocus"
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    data-variant="{{ $variant }}"
    data-size="{{ $size }}"
    {{ $attributes->except(['class', 'autofocus', 'variant', 'size', 'dataSlot']) }}
>
    {{ $slot }}
</x-alert-dialog.primitive.cancel>
