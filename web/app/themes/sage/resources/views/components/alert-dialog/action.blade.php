@props([
    'variant' => 'default',
    'size' => 'default',
    'dataSlot' => 'alert-dialog-action',
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

<x-alert-dialog.primitive.action
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    data-variant="{{ $variant }}"
    data-size="{{ $size }}"
    {{ $attributes->except(['class', 'variant', 'size', 'dataSlot']) }}
>
    {{ $slot }}
</x-alert-dialog.primitive.action>
