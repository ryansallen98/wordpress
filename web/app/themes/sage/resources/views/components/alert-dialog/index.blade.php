@props([
    'dataSlot' => 'alert-dialog',
])
@php
    $classes = $tw->merge('contents', $attributes->get('class'));
    $defaultOpen = $attributes->boolean('default-open') || $attributes->boolean('defaultOpen');
@endphp

<x-alert-dialog.primitive.root
    data-slot="{{ $dataSlot }}"
    class="{{ $classes }}"
    :default-open="$defaultOpen"
    {{ $attributes->except(['class', 'default-open', 'defaultOpen']) }}
>
    {{ $slot }}
</x-alert-dialog.primitive.root>
