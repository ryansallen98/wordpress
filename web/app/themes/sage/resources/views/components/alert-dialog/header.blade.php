@props([
    'dataSlot' => 'alert-dialog-header',
])
@php
    $classes = $tw->merge(
        'grid grid-rows-[auto_1fr] place-items-center gap-1.5 text-center has-data-[slot=alert-dialog-media]:grid-rows-[auto_auto_1fr] has-data-[slot=alert-dialog-media]:gap-x-4 sm:group-data-[size=default]/alert-dialog-content:place-items-start sm:group-data-[size=default]/alert-dialog-content:text-left sm:group-data-[size=default]/alert-dialog-content:has-data-[slot=alert-dialog-media]:grid-rows-[auto_1fr]',
        $attributes->get('class')
    );
@endphp

<div data-slot="{{ $dataSlot }}" class="{{ $classes }}" {{ $attributes->except('class') }}>
    {{ $slot }}
</div>
