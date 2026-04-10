@props([
    'dataSlot' => 'breadcrumb-item',
])
@php
    $classes = $tw->merge('inline-flex items-center gap-1.5', $attributes->get('class'));
@endphp

<li data-slot="{{ $dataSlot }}" class="{{ $classes }}" {{ $attributes->except(['class', 'dataSlot']) }}>
    {{ $slot }}
</li>
