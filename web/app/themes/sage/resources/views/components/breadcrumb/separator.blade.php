@props([
    'dataSlot' => 'breadcrumb-separator',
])
@php
    $classes = $tw->merge('[&>svg]:size-3.5', $attributes->get('class'));
@endphp

<li
    data-slot="{{ $dataSlot }}"
    role="presentation"
    aria-hidden="true"
    class="{{ $classes }}"
    {{ $attributes->except(['class', 'dataSlot']) }}
>
    @if (isset($slot) && ! $slot->isEmpty())
        {{ $slot }}
    @else
        <x-lucide-chevron-right aria-hidden="true" />
    @endif
</li>
