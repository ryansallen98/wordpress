@props([
    'dataSlot' => 'breadcrumb-page',
])
@php
    $classes = $tw->merge('font-normal text-foreground', $attributes->get('class'));
@endphp

<span
    data-slot="{{ $dataSlot }}"
    aria-current="page"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'dataSlot']) }}
>
    {{ $slot }}
</span>
