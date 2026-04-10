@props([
    'dataSlot' => 'alert-dialog-media',
])
@php
    $classes = $tw->merge(
        "mb-2 inline-flex size-10 items-center justify-center rounded-md bg-muted sm:group-data-[size=default]/alert-dialog-content:row-span-2 *:[svg:not([class*='size-'])]:size-6",
        $attributes->get('class')
    );
@endphp

<div data-slot="{{ $dataSlot }}" class="{{ $classes }}" {{ $attributes->except('class') }}>
    {{ $slot }}
</div>
